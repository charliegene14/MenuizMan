<?php

/**
 * Undocumented function
 *
 * @param array $aCompArticle
 * @param [type] $i
 * @return void
 */
function article_show_recursive(array $aCompArticle, $i) {
    if (count($aCompArticle) === 0) return;
    $i++;

    foreach ($aCompArticle as $cArticle) {
        
        for ($j = 0; $j < $i; $j++) {
            echo " 	&mdash; ";
        }
        
        echo " (x " . $cArticle->getQuantity() . " ) <a href='./?p=article&action=show&id=" .$cArticle->getArticle()->getId(). "'>" . $cArticle->getArticle()->getName() . "</a><br />";

        if ($cArticle->getArticle()->getComposition()) {
            article_show_recursive($cArticle->getArticle()->getComposition(), $i);
        }
    }
}