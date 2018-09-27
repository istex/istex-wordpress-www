<?php
/*  
* Template Name: Item_domain  
*/
$context = Timber::get_context();

// récupération route
$urlRetrieve = $_SERVER['HTTP_REFERER'];
$corpusRetrieve = $_GET['itemcorpus']; 
$domainRetrieve = $_GET['itemdomain']; 
$context['retrieve'] = array('itemcorpus' => $corpusRetrieve, "itemdomain" => $domainRetrieve,  "url" => $urlRetrieve);

/* Récupération des données lodex */
$spinned = get_data_istex_with_cache('spinned','https://pinned-docs.data.istex.fr/api/run/all-documents?$limit=1000');
$domains = get_data_istex_with_cache('domains','https://scientific-domain.data.istex.fr/api/run/all-documents');
$corpus = get_data_istex_with_cache('corpus','https://loaded-corpus.data.istex.fr/api/run/all-documents?maxSize=1000');

// traitement corpus
for ($i = 0; $i < $corpus['total']; $i++) {
		$context['corpus'][$i] = $corpus['data'][$i];
		foreach ($context['corpus'][$i] as $k => $value) {
			$newk = "data_".$k;
			$context['corpus'][$i][$newk] = $context['corpus'][$i][$k];
			unset($context['corpus'][$i][$k]);
			$context['corpus'][$i][data_dArk] = "ark:".explode("ark:", $context['corpus'][$i]['data_kEyw'][0])[1];
		}
}

// traitement domaines
for ($j = 0; $j < $domains['total']; $j++) {
	$abrev = $domains['data'][$j][BhIX];

	if ($domainRetrieve == $abrev){
		$context['scientific'] = array("abrev" => $domainRetrieve,"name" => $domains['data'][$j][a20Y], "uri" => $domains['data'][$j][uri]);
	}
}

// traitement documents épinglés
for ($i = 0; $i < $spinned['total']; $i++) {
	$context['spinnedoc'][$i] = $spinned['data'][$i];
	$slugdomain = "ark:".explode("ark:", $context['spinnedoc'][$i]['ULvS'])[1];

	for ($j = 0; $j < $domains['total']; $j++) {
		if ($domains['data'][$j]['uri'] == $slugdomain) {
			$context['spinnedoc'][$i]['abrev'] = $domains['data'][$j]['BhIX'];
		}
	}
}
Timber::render('item_domain.twig', $context);
