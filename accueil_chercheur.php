<?php
/*Template Name: Accueil_Chercheur*/
$context = Timber::get_context();

/* Récupération des données */
$documents = json_decode(file_get_contents('https://api.istex.fr/document/?q=*&size=0&sid=istex-www'), true);
$context['domains'] = json_decode(file_get_contents('https://scientific-domain.data.istex.fr/api/run/all-documents'), true);
$context['corpus'] = json_decode(file_get_contents('https://loaded-corpus.data.istex.fr/api/run/all-documents?maxSize=1000'), true);

// traitement corpus
for ($i = 0; $i < $context['corpus']['total']; $i++) {
	foreach (array_keys($context['corpus']['data'][$i]) as $v) {
		$newv = "data_".$v;
		$context['corpus']['data'][$i][$newv] = $context['corpus']['data'][$i][$v];
		unset($context['corpus']['data'][$i][$v]);
	}
	$titres = $titres + $context['corpus']['data'][$i]['data_68is'];
	$ebooks = $ebooks + $context['corpus']['data'][$i]['data_IWa6'];
}

/* formatage et envoie des données chiffrées */
$context['donneeschercheur'] = array(	"nbdoc" => number_format($documents['total'],'0',',',' '),
										"titres" => number_format($titres,'0',',',' '),
										"ebooks" => number_format($ebooks,'0',',',' ')
								);

$context['termservices'] = new TimberTerm('services_chercheurs');
$context['termusages'] = new TimberTerm('ils_ont_utilise_istex');
$context['postschercheurs'] = Timber::get_posts(array('category_name' => 'services_chercheurs' ));
$context['postsusages'] = Timber::get_posts(array('category_name' => 'ils_ont_utilise_istex' ));
$context['dynamic_sidebar'] = Timber::get_widgets('soutenir_istex');


Timber::render('accueil_chercheur.twig', $context);
//print_r($context['postsusages']);