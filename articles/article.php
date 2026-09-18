<?php
$articles = [
	'nutrition-cycle' => [
		'categorie' => 'Nutrition',
		'titre' => 'Bien manger pendant les différentes phases',
		'intro' => 'Une alimentation régulière et variée peut aider à soutenir l energie et le confort pendant tout le cycle.',
		'sections' => [
			'Misez sur la régularité' => 'Associez une source de protéines, des féculents complets, des légumes et une matière grasse de qualité à chaque repas.',
			'Pensez à l hydratation' => 'Boire régulièrement peut contribuer à réduire la fatigue et les maux de tête. Gardez une bouteille près de vous.',
			'Écoutez votre appétit' => 'Les besoins peuvent varier. Prévoir une collation simple, comme un fruit et quelques noix, évite de rester trop longtemps sans manger.',
		],
	],
	'energie-cycle' => [
		'categorie' => 'Énergie',
		'titre' => 'Comprendre ses variations d énergie',
		'intro' => 'Le niveau d énergie n est pas constant. L observer permet de choisir des objectifs réalistes et de mieux respecter ses limites.',
		'sections' => [
			'Observer sans se juger' => 'Notez votre énergie pendant quelques cycles et cherchez des tendances plutôt que des règles absolues.',
			'Adapter son activité' => 'Quand l énergie est bonne, une activité plus soutenue peut convenir. Les jours plus difficiles, une marche ou des étirements sont déjà utiles.',
			'Préserver son sommeil' => 'Une routine régulière, une lumière plus douce le soir et un temps de repos suffisant soutiennent la récupération.',
		],
	],
	'symptomes-regles' => [
		'categorie' => 'Bien-être',
		'titre' => 'Soulager les symptômes avec douceur',
		'intro' => 'Quelques gestes simples peuvent améliorer le confort, mais une douleur inhabituelle ou intense mérite un avis médical.',
		'sections' => [
			'La chaleur et le repos' => 'Une bouillotte protégée par un tissu et une position confortable peuvent aider à détendre les muscles.',
			'Le mouvement doux' => 'Une marche lente, des étirements ou une respiration profonde peuvent réduire la sensation de tension chez certaines personnes.',
			'Quand demander conseil' => 'Consultez un professionnel si la douleur est très forte, nouvelle, persistante ou si elle perturbe fortement votre quotidien.',
		],
	],
];

$slug = $_GET['slug'] ?? 'nutrition-cycle';
$article = $articles[$slug] ?? $articles['nutrition-cycle'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Flo. - <?= htmlspecialchars($article['titre']) ?></title>
	<style>
		body { margin: 0; min-height: 100vh; background: linear-gradient(45deg, #6d11b8, #ff4b90); color: #21172f; font-family: Arial, sans-serif; }
		.page { width: min(760px, calc(100% - 32px)); margin: auto; padding: 28px 0 60px; }
		.back, .eyebrow { color: #fff; font-weight: 700; text-decoration: none; }
		.article { margin-top: 48px; padding: 32px; border: 1px solid rgba(255,255,255,.35); border-radius: 16px; background: rgba(255,255,255,.9); box-shadow: 0 16px 35px rgba(45, 8, 70, .18); }
		h1 { margin: 10px 0 20px; color: #3b075f; font-size: 34px; line-height: 1.15; }
		h2 { margin-top: 28px; color: #3b075f; font-size: 20px; }
		p { line-height: 1.65; }
		.intro { color: #55495b; font-size: 17px; }
		@media (max-width: 600px) { .article { padding: 22px 18px; } h1 { font-size: 27px; } }
	</style>
</head>
<body>
	<main class="page">
		<a class="back" href="index.php">← Tous les articles</a>
		<article class="article">
			<small class="eyebrow" style="color:#a53e70;"><?= htmlspecialchars($article['categorie']) ?></small>
			<h1><?= htmlspecialchars($article['titre']) ?></h1>
			<p class="intro"><?= htmlspecialchars($article['intro']) ?></p>
			<?php foreach ($article['sections'] as $heading => $content): ?>
				<section>
					<h2><?= htmlspecialchars($heading) ?></h2>
					<p><?= htmlspecialchars($content) ?></p>
				</section>
			<?php endforeach; ?>
		</article>
	</main>
</body>
</html>
