<?php
$context = Timber::get_context();

// récuperation des données en ligne
$context['corpus'] = json_decode(file_get_contents('https://loaded-corpus.data.istex.fr/api/run/all-documents?maxSize=1000'), true);
$documents = json_decode(file_get_contents('https://api.istex.fr/document/?q=*&size=0&sid=istex-www'), true);
$from = $upto = 2000;

// traitement corpus
for ($i = 0; $i < $context['corpus']['total']; $i++) {
	foreach (array_keys($context['corpus']['data'][$i]) as $v) {
		$newv = "data_".$v;
		$context['corpus']['data'][$i][$newv] = $context['corpus']['data'][$i][$v];
		unset($context['corpus']['data'][$i][$v]);
	}
	$titres = $titres + $context['corpus']['data'][$i]['data_68is'];
	$ebooks = $ebooks + $context['corpus']['data'][$i]['data_IWa6'];
	$from = min($from,$context['corpus']['data'][$i]['data_DDU1']);
	$upto = max($upto,$context['corpus']['data'][$i]['data_dMc5']);
}

/* formatage et envoie ddes données chiffrées */
$context['donneesgenerales'] = array(	"nbdoc" => number_format($documents['total'],'0',',',' '),
										"titres" => number_format($titres,'0',',',' '),
										"corpus" => number_format($context['corpus']['total'],'0',',',' '),
										"ebooks" => number_format($ebooks,'0',',',' '),
										"from" => $from,
										"upto" => $upto
								);

// Set a home page variable
$context['is_home'] = 'true';
Timber::render('index.twig', $context);
// print_r($context);
