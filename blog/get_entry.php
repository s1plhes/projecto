<?php

//Getting the data frorm the supeglobals GET by the ID of the blog entry
    $entrygetid = filter_input_array($_GET['page_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sql = engine->run("SELECT * FROM blog WHERE id=?",[$entrygetid]);
        if ($sql->rowCount() < 0) {
            // Simple error to display if the id for the product doesn't exists (array is empty)
            $result_error = "No data";
        }
    $entrytitle = $row['title'];
    $entrytxt = htmlspecialchars_decode($row['text']);
    $entryauthor = urlFetch($row['author']);
    $entrydate = $row['date'];
