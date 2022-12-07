<?php

//Getting the data frorm the supeglobals GET by the ID of the blog entry
    $entrygetid = $_GET['page_id'];
    $sql = "SELECT * FROM blog WHERE id=$entrygetid";
    $result = mysqli_query(conn,$sql);
    $row = mysqli_fetch_assoc($result);
        if (!$row) {
            // Simple error to display if the id for the product doesn't exists (array is empty)
            $result_error = "No data";
        }
    $entrytitle = $row['title'];
    $entrytxt = htmlspecialchars_decode($row['text']);
    $entryauthor = urlFetch($row['author']);
    $entrydate = $row['date'];
