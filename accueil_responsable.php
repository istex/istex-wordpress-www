<?php
/*Template Name: Accueil_Responsable*/
$context = Timber::get_context();

// récuperation des données en ligne
$documents = get_data_istex_with_cache('documents', 'https://api.istex.fr/document/?q=*&size=0&sid=istex-www');
$context['domains'] = get_data_istex_with_cache('domains','https://scientific-domain.data.istex.fr/api/run/all-documents');
$context['corpus'] = get_data_istex_with_cache('corpus','https://loaded-corpus.data.istex.fr/api/run/all-documents?maxSize=1000');
$etablissement = get_data_istex_with_cache('etablissement','https://authorized-user.data.istex.fr/api/run/count-all');

// traitement corpus
for ($i = 0; $i < $context['corpus']['total']; $i++) {
	foreach (array_keys($context['corpus']['data'][$i]) as $v) {
		$newv = "data_".$v;
		$context['corpus']['data'][$i][$newv] = $context['corpus']['data'][$i][$v];
		unset($context['corpus']['data'][$i][$v]);
	}
}

// traitement disciplines
for ($j = 0; $j < $context['domains']['total']; $j++) {
	$newvalue = explode(":/", $context['domains']['data'][$j]['_id'])[1];
	$context['domains']['data'][$j]['_id'] = $newvalue;
}

/* formatage et envoie ddes données chiffrées */
$context['donneesresponsable'] = array(	"nbdoc" => number_format($documents['total'],'0',',',' '),
										"etablissement" => number_format($etablissement,'0',',',' '),
										"corpus" => number_format($context['corpus']['total'],'0',',',' ')
								);


$context['postsservices'] = Timber::get_posts(array('category_name' => 'services_institutions' ));
$context['termservices'] = new TimberTerm('services_institutions');
$context['postsresponsables'] = Timber::get_posts(array('category_name' => 'responsables' ));
$context['termresponsables'] = new TimberTerm('responsables');
$context['postssoutenez'] = Timber::get_posts(array('category_name' => 'soutenez_istex' ));
$context['termsoutenez'] = new TimberTerm('soutenez_istex');
$context['dynamic_sidebar'] = Timber::get_widgets('voir_page_chercheur');
Timber::render('accueil_responsable.twig', $context);
//print_r($context['donneesreponsable']);
