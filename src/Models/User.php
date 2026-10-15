<?php
// /src/Models/User.php

class User
{
    //  * Busca un usuario por su nickname de forma inmune a mayúsculas/minúsculas en producción

    public static function findByUsername($username)
    {
        try {
            $db = Database::getConnection();

            // 🌟 BLINDAJE DE PRODUCCIÓN: Pasamos ambos lados a minúsculas y limpiamos espacios con trim()
            $sql = "SELECT * FROM users WHERE LOWER(username) = LOWER(:username) LIMIT 1";

            $stmt = $db->prepare($sql);
            $stmt->execute(['username' => trim($username)]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            return $user;
        } catch (PDOException $e) {
            // En caso de fallo preventivo en el hosting, retornamos falso
            return false;
        }
    }

    // Devuelve cuántos usuarios existen, o null si la base de datos no responde
    public static function count()
    {
        try {
            $db = Database::getConnection();
            return (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        } catch (PDOException $e) {
            return null;
        }
    }

    //  * Recupera todos los usuarios cruzando los datos con sus perfiles de rol reales

    public static function all()
    {
        try {
            $db = Database::getConnection();

            // 🌟 CONEXIÓN RELACIONAL SEGÚN TU VOLCADO:
            // Cruzamos u.perfiles_id con p.id_perfil para extraer la columna 'perfil' textualmente
            $sql = "SELECT u.*, p.perfil 
                    FROM users u
                    INNER JOIN perfiles p ON u.perfil_id = p.id_perfil
                    ORDER BY u.id_user ASC";

            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error crítico en el modelo de usuarios al consultar el personal: " . $e->getMessage());
        }
    }

    //  * Busca un usuario específico por su ID

    public static function find($id)
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE id_user = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    //  * Registra un nuevo empleado de forma limpia en tu base de datos real

    public static function save($data)
    {
        try {
            $db = Database::getConnection();

            // 🌟 SINCRO TOTAL CON TU VOLCADO SQL: Eliminamos las columnas 'parrafos' y 'titulos' que no existen en la tabla users
            $sql = "INSERT INTO users (nombre, apellidos, email, username, password, perfil_id, activo) 
                    VALUES (:nombre, :apellidos, :email, :username, :password, :perfil_id, :activo)";

            $stmt = $db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            // Si en tus pruebas locales deseas auditar qué error te da MariaDB en pantalla, puedes descomentar la línea de abajo:
            // die("Error SQL en inserción de usuarios: " . $e->getMessage());
            return false;
        }
    }

    //  * Actualiza los datos de un usuario (la contraseña es opcional)

    public static function update($id, $data, $updatePassword = false)
    {
        try {
            $db = Database::getConnection();
            $sql = "UPDATE users SET 
                        nombre = :nombre, 
                        apellidos = :apellidos, 
                        email = :email, 
                        username = :username, 
                        perfil_id = :perfil_id, 
                        activo = :activo";

            if ($updatePassword) {
                $sql .= ", password = :password";
            }

            $sql .= " WHERE id_user = :id";

            $data['id'] = $id;
            $stmt = $db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
