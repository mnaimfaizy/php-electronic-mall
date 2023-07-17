<?php require_once('../includes/initialize.php');
    $sql = "SELECT review_id, name, review, date_added, COUNT(review_id) AS total 
            FROM product_review 
            WHERE date_added <=" . (time()-(60*60*24)) ." 
            GROUP BY review_id, name, review, date_added";
        $sqlResult = $database->query($sql);
        $row = $database->fetch_array($sqlResult);
        $new_review = $row['total'];
        $name = $row['name'];
        $review = $row['review'];
        if($new_review > 0) {
            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                echo '<i class="icon-envelope-alt"></i>';
                echo '<span class="badge">'. $new_review .'</span>';
                echo '</a>';
        } else {
            echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
                echo '<i class="icon-envelope-alt"></i>';
                echo '</a>';
        }
                echo '<ul class="dropdown-menu extended inbox">';
                echo '<li>';
                    if($new_review > 0) {
                        echo '<p>You have '. $new_review .' new product review</p>';
                    } else {
                        echo '<p>You have no new product review</p>';
                    }
                echo '</li>';
                echo '<li>';
                    echo '<a href="#">';
                    echo '<span class="subject">';
                    echo '<span class="from">'. $name .'</span>';
                    echo '</span>';
                    echo '<span class="message">';
                    echo $review;
                    echo '</span> ';
                    echo '</a>';
                echo '</li>';
                echo '<li class="external">';
                    echo '<a href="#">See all products review <i class="m-icon-swapright"></i></a>';
                echo '</li>';
            echo '</ul>';
