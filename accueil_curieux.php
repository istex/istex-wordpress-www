<?php
/*Template Name: Accueil_Curieux*/
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

$context['postscurieux'] = Timber::get_posts(array('category_name' => 'curieux' ));
$context['termcurieux'] = new TimberTerm('curieux');
$context['postspourqui'] = Timber::get_posts(array('category_name' => 'pour_qui_curieux' ));
$context['termpourqui'] = new TimberTerm('pour_qui_curieux');
$context['postshistorique'] = Timber::get_posts(array('category_name' => 'historique_istex' ));
$context['termhistorique'] = new TimberTerm('historique_istex');
$context['postspresse'] = Timber::get_posts(array('category_name' => 'kit_de_presse' ));

/* formatage et envoie ddes données chiffrées */
$context['donneeschercheur'] = array(	"nbdoc" => number_format($documents['total'],'0',',',' '),
										"titres" => number_format($titres,'0',',',' '),
										"ebooks" => number_format($ebooks,'0',',',' ')
								);

$context['termpresse'] = new TimberTerm('kit_de_presse');
Timber::render('accueil_curieux.twig', $context);
//print_r($context);
