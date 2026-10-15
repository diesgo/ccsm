<?php
// /src/Models/Perfil.php

class Perfil
{
    /**
     * Obtiene todos los perfiles registrados en el sistema
     * @return array Listado de roles
     */
    public static function all()
    {
        try {
            $db = Database::getConnection();
            return $db->query("SELECT id_perfil, perfil FROM perfiles ORDER BY id_perfil ASC")->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Crea un nuevo rol o rango de usuario en el sistema
     * @param string $perfil Nombre del nuevo rango
     * @return bool True si se guardó con éxito, false en caso contrario
     */
    public static function save($perfil)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("INSERT INTO perfiles (perfil) VALUES (:perfil)");
            // Forzamos el guardado en minúsculas por consistencia interna del framework
            return $stmt->execute(['perfil' => strtolower(trim($perfil))]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function find($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM perfiles WHERE id_perfil = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Actualiza la matriz granular de privilegios (Ver / Crear / Editar) de un rol en MariaDB
     * @param int $id
     * @param string $nombrePerfil
     * @param array $permisos
     * @return bool
     */
    public static function update($id, $nombrePerfil, $permisos) {
        try {
            $db = Database::getConnection();

            // Consulta preparada con las 24 columnas granulares (8 módulos x Ver/Crear/Editar)
            $sql = "UPDATE perfiles SET 
                        perfil = :perfil,
                        ver_socios = :ver_socios,
                        crear_socios = :crear_socios,
                        edit_socios = :edit_socios,
                        ver_productos = :ver_productos,
                        crear_productos = :crear_productos,
                        edit_productos = :edit_productos,
                        ver_variedades = :ver_variedades,
                        crear_variedades = :crear_variedades,
                        edit_variedades = :edit_variedades,
                        ver_categorias = :ver_categorias,
                        crear_categorias = :crear_categorias,
                        edit_categorias = :edit_categorias,
                        ver_proveedores = :ver_proveedores,
                        crear_proveedores = :crear_proveedores,
                        edit_proveedores = :edit_proveedores,
                        ver_personal = :ver_personal,
                        crear_personal = :crear_personal,
                        edit_personal = :edit_personal,
                        ver_roles = :ver_roles,
                        crear_roles = :crear_roles,
                        edit_roles = :edit_roles,
                        ver_cuotas = :ver_cuotas,
                        crear_cuotas = :crear_cuotas,
                        edit_cuotas = :edit_cuotas
                    WHERE id_perfil = :id";

            $stmt = $db->prepare($sql);

            // Ejecutamos asociando de forma exacta el nombre y las 24 llaves booleanas
            return $stmt->execute([
                'id'                 => intval($id),
                'perfil'             => trim($nombrePerfil),
                'ver_socios'         => intval($permisos['ver_socios'] ?? 0),
                'crear_socios'       => intval($permisos['crear_socios'] ?? 0),
                'edit_socios'        => intval($permisos['edit_socios'] ?? 0),
                'ver_productos'      => intval($permisos['ver_productos'] ?? 0),
                'crear_productos'    => intval($permisos['crear_productos'] ?? 0),
                'edit_productos'     => intval($permisos['edit_productos'] ?? 0),
                'ver_variedades'     => intval($permisos['ver_variedades'] ?? 0),
                'crear_variedades'   => intval($permisos['crear_variedades'] ?? 0),
                'edit_variedades'    => intval($permisos['edit_variedades'] ?? 0),
                'ver_categorias'     => intval($permisos['ver_categorias'] ?? 0),
                'crear_categorias'   => intval($permisos['crear_categorias'] ?? 0),
                'edit_categorias'    => intval($permisos['edit_categorias'] ?? 0),
                'ver_proveedores'    => intval($permisos['ver_proveedores'] ?? 0),
                'crear_proveedores'  => intval($permisos['crear_proveedores'] ?? 0),
                'edit_proveedores'   => intval($permisos['edit_proveedores'] ?? 0),
                'ver_personal'       => intval($permisos['ver_personal'] ?? 0),
                'crear_personal'     => intval($permisos['crear_personal'] ?? 0),
                'edit_personal'      => intval($permisos['edit_personal'] ?? 0),
                'ver_roles'          => intval($permisos['ver_roles'] ?? 0),
                'crear_roles'        => intval($permisos['crear_roles'] ?? 0),
                'edit_roles'         => intval($permisos['edit_roles'] ?? 0),
                'ver_cuotas'         => intval($permisos['ver_cuotas'] ?? 0),
                'crear_cuotas'       => intval($permisos['crear_cuotas'] ?? 0),
                'edit_cuotas'        => intval($permisos['edit_cuotas'] ?? 0)
            ]);

        } catch (PDOException $e) {
            // En entorno de desarrollo puedes descomentar la línea de abajo si necesitas depurar:
            // die("Error crítico al actualizar matriz RBAC: " . $e->getMessage());
            return false;
        }
    }

}
?>
