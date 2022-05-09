<div id="search-results">
<?php

foreach($displayTable as $result) {
        
    ?>

    <div class="found-item">
        <div class="infos-client">
            <div class="search-subtittle"><div><span><?php echo $result[0] ?></span></div><div class="accordeon-arrow"><i class="fa-solid fa-arrow-down"></div></i></div>
                <div class="search-default-hidden">
                    <div>
                        <?php
                            for ($i=1;$i< count($result)-1;$i++) {
                                echo "<div>" . $result[$i] . "</div>";

                            }
                        ?>
                       
                    </div>

                    <div>
                        <a href=<?php echo ($result[count($result)-1]) ?>><input type="button" class="btn-primary" value="Détails"></a>
                    </div>
                

                </div>  
            </div>   
            </div> 
            
    
 

<?php
    }
?>
</div>  





