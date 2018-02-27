<?php
/*  
* Template Name: Item_corpus 
*/
$context = Timber::get_context();

// récupération route
$urlRetrieve = $_SERVER['HTTP_REFERER'];
$corpusRetrieve = $_GET['itemcorpus']; 
$domainRetrieve = $_GET['itemdomain']; 
$context['retrieve'] = array('itemcorpus' => $corpusRetrieve, "itemdomain" => $domainRetrieve,  "url" => $urlRetrieve);

/* Récupération des données lodex */
$domains = get_data_istex_with_cache('domains','https://scientific-domain.data.istex.fr/api/run/all-documents');
$corpus = get_data_istex_with_cache('corpus','https://loaded-corpus.data.istex.fr/api/run/all-documents?maxSize=1000');

// traitement corpus
for ($i = 0; $i < $corpus['total']; $i++) {
	if ($corpus['data'][$i][JP7t] == $corpusRetrieve) { 
		$context['corpus'] = $corpus['data'][$i];
		foreach ($context['corpus'] as $k => $value) {
			$newk = "data_".$k;
			$context['corpus'][$newk] = $context['corpus'][$k];
			unset($context['corpus'][$k]);
		}
		$slugdomain = "ark:".explode("ark:", $context['corpus']['data_kEyw'])[1];
		for ($j = 0; $j < $domains['total']; $j++) {
			if ($domains['data'][$j]['uri'] == $slugdomain) {
				$context['corpus']['abrev'] = $domains['data'][$j]['BhIX'];
			}
		}
	}
}
//print_r($context['corpus']);
Timber::render('item_corpus.twig', $context);
