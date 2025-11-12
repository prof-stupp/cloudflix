<?php

/**
 * Função CREATE (POST /api.php?resource=filmes)
 */
function createFilme($pdo, $data) {
    if (empty($data['titulo']) || empty($data['genero'])) {
        http_response_code(400);
        return array("message" => "Dados incompletos: título e gênero são obrigatórios.");
    }
    
    // ATENÇÃO: Para PostgreSQL, usamos RETURNING id para obter o ID inserido.
    $sql = "INSERT INTO filmes (titulo, genero, cartaz) VALUES (?, ?, ?, ?) RETURNING id";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['titulo'],
            $data['genero'],
            $data['cartaz'] ?? null 
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $new_id = $result['id'] ?? null;
        
        http_response_code(201);
        return array("message" => "Filme criado com sucesso.", "id" => $new_id);
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao criar filme: " . $e->getMessage());
    }
}

/**
 * Função READ (GET /api.php?resource=filmes ou GET /api.php?resource=filmes&id=2)
 */
function readFilmes($pdo, $id) {
    if ($id) {
        // READ ONE
        $sql = "SELECT id, titulo, genero, cartaz FROM filmes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $filme = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($filme) {
            http_response_code(200);
            return $filme;
        } else {
            http_response_code(404);
            return array("message" => "Filme não encontrado.");
        }
    } else {
        // READ ALL
        $sql = "SELECT id, titulo, genero, cartaz FROM filmes ORDER BY id DESC";
        $stmt = $pdo->query($sql);
        $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($filmes) {
            http_response_code(200);
            return $filmes;
        } else {
            http_response_code(200); // Retorna 200 e um array vazio se não houver filmes
            return [];
        }
    }
}

/**
 * Função UPDATE (PUT /api.php?resource=filmes&id=2)
 */
function updateFilme($pdo, $id, $data) {
    if (!$id || empty($data['titulo']) || empty($data['genero'])) {
        http_response_code(400);
        return array("message" => "Dados incompletos ou ID ausente.");
    }

    $sql = "UPDATE filmes SET titulo = ?, genero = ?, cartaz = ? WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['titulo'],
            $data['genero'],
            $data['cartaz'] ?? null,
            $id
        ]);
        
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            return array("message" => "Filme atualizado com sucesso.");
        } else {
            http_response_code(404);
            return array("message" => "Filme não encontrado ou nenhum dado para atualizar.");
        }
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao atualizar filme: " . $e->getMessage());
    }
}

/**
 * Função DELETE (DELETE /api.php?resource=filmes&id=2)
 */
function deleteFilme($pdo, $id) {
    if (!$id) {
        http_response_code(400);
        return array("message" => "ID do filme é obrigatório para exclusão.");
    }

    $sql = "DELETE FROM filmes WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            return array("message" => "Filme excluído com sucesso.");
        } else {
            http_response_code(404);
            return array("message" => "Filme não encontrado.");
        }
    } catch (PDOException $e) {
        http_response_code(503);
        return array("message" => "Erro ao excluir filme: " . $e->getMessage());
    }
}

?>