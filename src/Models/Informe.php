<?php

class Informe
{
    public const TAMANO_PAGINA = 50;
    public const TIPOS = [
        'ventas' => 'Historial de ventas',
        'compras' => 'Historial de compras',
        'productos' => 'Ventas por producto',
        'socios' => 'Ventas por socio'
    ];

    public static function filtros($entrada)
    {
        $filtros = ['tipo' => 'ventas', 'desde' => '', 'hasta' => '', 'producto' => 0, 'socio' => 0, 'proveedor' => 0, 'pagina' => 1];
        foreach ($filtros as $clave => $defecto) {
            if (!isset($entrada[$clave])) {
                continue;
            }
            if (!is_string($entrada[$clave]) && !is_int($entrada[$clave])) {
                throw new InvalidArgumentException('Los filtros del informe no son válidos.');
            }
            $valor = trim((string) $entrada[$clave]);
            if (in_array($clave, ['producto', 'socio', 'proveedor', 'pagina'], true)) {
                $numero = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => $clave === 'pagina' ? 1 : 0]]);
                if ($numero === false) {
                    throw new InvalidArgumentException('Los identificadores y la página deben ser números válidos.');
                }
                $filtros[$clave] = $numero;
            } else {
                $filtros[$clave] = $valor;
            }
        }
        if (!isset(self::TIPOS[$filtros['tipo']])) {
            throw new InvalidArgumentException('Selecciona un tipo de informe válido.');
        }
        foreach (['desde', 'hasta'] as $campo) {
            if ($filtros[$campo] !== '') {
                if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/D', $filtros[$campo])) {
                    throw new InvalidArgumentException('Introduce las fechas en formato AAAA-MM-DD.');
                }
                $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $filtros[$campo]);
                if (!$fecha || $fecha->format('Y-m-d') !== $filtros[$campo] || $filtros[$campo] > '9999-12-30') {
                    throw new InvalidArgumentException('Introduce las fechas en formato AAAA-MM-DD.');
                }
            }
        }
        if ($filtros['desde'] !== '' && $filtros['hasta'] !== '' && $filtros['desde'] > $filtros['hasta']) {
            throw new InvalidArgumentException('La fecha inicial no puede ser posterior a la final.');
        }
        if ($filtros['tipo'] === 'compras') {
            $filtros['socio'] = 0;
        } else {
            $filtros['proveedor'] = 0;
        }
        return $filtros;
    }

    public static function opciones()
    {
        $db = Database::getConnection();
        return [
            'productos' => $db->query('SELECT id_producto AS id, producto AS nombre FROM productos ORDER BY producto')->fetchAll(),
            'socios' => $db->query("SELECT id_socio AS id, CONCAT_WS(' ', nombre, apellidos) AS nombre FROM socios ORDER BY nombre, apellidos")->fetchAll(),
            'proveedores' => $db->query('SELECT id_proveedor AS id, proveedor AS nombre FROM proveedores ORDER BY proveedor')->fetchAll()
        ];
    }

    public static function obtener($filtros)
    {
        $db = Database::getConnection();
        $esCompra = $filtros['tipo'] === 'compras';
        $fecha = $esCompra ? 'r.date_compra' : 'r.date_add_venta';
        $cantidad = $esCompra ? 'r.unidades' : 'r.cantidad';
        $desde = $esCompra ? ' FROM compras r' : ' FROM ventas r';
        $desde .= ' LEFT JOIN productos p ON r.producto_id = p.id_producto
                    LEFT JOIN categorias c ON p.categoria_id = c.id_categoria
                    LEFT JOIN servicios m ON c.servicio_id = m.id_servicio';
        $desde .= $esCompra
            ? ' LEFT JOIN proveedores pr ON r.proveedor_id = pr.id_proveedor'
            : ' LEFT JOIN socios s ON r.socio_id = s.id_socio';
        $condiciones = [];
        $params = [];
        if ($filtros['desde'] !== '') {
            $condiciones[] = "$fecha >= :desde";
            $params['desde'] = $filtros['desde'] . ' 00:00:00';
        }
        if ($filtros['hasta'] !== '') {
            $condiciones[] = "$fecha < :hasta";
            $params['hasta'] = (new DateTimeImmutable($filtros['hasta']))->modify('+1 day')->format('Y-m-d') . ' 00:00:00';
        }
        foreach (['producto', $esCompra ? 'proveedor' : 'socio'] as $campo) {
            if ($filtros[$campo] > 0) {
                $condiciones[] = "r.{$campo}_id = :$campo";
                $params[$campo] = $filtros[$campo];
            }
        }
        $desde .= $condiciones ? ' WHERE ' . implode(' AND ', $condiciones) : '';
        $cantidades = "COALESCE(SUM(CASE WHEN c.servicio_id = 2 THEN $cantidad ELSE 0 END), 0) AS unidades,
                       COALESCE(SUM(CASE WHEN c.servicio_id = 1 THEN $cantidad ELSE 0 END), 0) AS gramos,
                       COALESCE(SUM(CASE WHEN c.servicio_id IS NULL OR c.servicio_id NOT IN (1, 2) THEN $cantidad ELSE 0 END), 0) AS sin_medida";
        $resumen = $db->prepare("SELECT COUNT(*) AS operaciones, COALESCE(SUM(r.total), 0) AS importe, $cantidades" . $desde);
        $resumen->execute($params);
        $totales = $resumen->fetch();
        $grupo = '';
        switch ($filtros['tipo']) {
            case 'productos':
                $seleccion = "r.producto_id AS id, p.producto AS nombre, m.servicio,
                              COUNT(*) AS operaciones, SUM($cantidad) AS cantidad, SUM(r.total) AS importe";
                $grupo = ' GROUP BY r.producto_id, p.producto, m.servicio';
                $orden = ' ORDER BY importe DESC, r.producto_id ASC';
                break;
            case 'socios':
                $seleccion = "r.socio_id AS id, CONCAT_WS(' ', s.nombre, s.apellidos) AS nombre,
                              COUNT(*) AS operaciones, SUM(r.total) AS importe, $cantidades";
                $grupo = ' GROUP BY r.socio_id, s.nombre, s.apellidos';
                $orden = ' ORDER BY importe DESC, r.socio_id ASC';
                break;
            case 'compras':
                $seleccion = "r.id_compra AS id, $fecha AS fecha, r.producto_id, p.producto,
                              r.proveedor_id AS entidad_id, pr.proveedor AS entidad, m.servicio,
                              $cantidad AS cantidad, r.pcm, r.iva, r.total AS importe";
                $orden = ' ORDER BY r.date_compra DESC, r.id_compra DESC';
                break;
            default:
                $seleccion = "r.id_venta AS id, $fecha AS fecha, r.producto_id, p.producto,
                              r.socio_id AS entidad_id, CONCAT_WS(' ', s.nombre, s.apellidos) AS entidad,
                              m.servicio, $cantidad AS cantidad, r.total AS importe";
                $orden = ' ORDER BY r.date_add_venta DESC, r.id_venta DESC';
        }
        $consulta = 'SELECT ' . $seleccion . $desde . $grupo;
        $cuenta = $db->prepare('SELECT COUNT(*) FROM (' . $consulta . ') listado');
        $cuenta->execute($params);
        $registros = (int) $cuenta->fetchColumn();
        $paginas = max(1, (int) ceil($registros / self::TAMANO_PAGINA));
        $pagina = min($filtros['pagina'], $paginas);
        $offset = ($pagina - 1) * self::TAMANO_PAGINA;
        $stmt = $db->prepare($consulta . $orden . ' LIMIT ' . self::TAMANO_PAGINA . ' OFFSET ' . $offset);
        $stmt->execute($params);
        return ['filas' => $stmt->fetchAll(), 'totales' => $totales, 'registros' => $registros, 'pagina' => $pagina, 'paginas' => $paginas];
    }
}
