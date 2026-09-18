<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Flo. - Articles</title>
	<style>
		:root { --plum: #3b075f; --pink: #ff4b90; --bg: #fcf4f5; --text: #21172f; }
		* { box-sizing: border-box; }
		body { margin: 0; min-height: 100vh; background: linear-gradient(45deg, #6d11b8, #ff4b90); color: var(--text); font-family: Arial, sans-serif; }
		.page { width: min(1080px, calc(100% - 32px)); margin: 0 auto; padding: 28px 0 60px; }
		.back { color: #fff; font-weight: 700; text-decoration: none; }
		header { margin: 45px 0 25px; color: #fff; }
		header h1 { margin: 8px 0; font-size: 32px; }
		header p { max-width: 650px; line-height: 1.5; }
		.articles { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
		article { display: flex; min-height: 280px; flex-direction: column; padding: 24px; border: 1px solid rgba(255,255,255,.35); border-radius: 16px; background: rgba(255,255,255,.86); box-shadow: 0 16px 35px rgba(45, 8, 70, .18); }
		article small { color: #a53e70; font-weight: 700; text-transform: uppercase; }
		article h2 { margin: 12px 0 8px; color: var(--plum); font-size: 20px; line-height: 1.2; }
		article p { color: #55495b; line-height: 1.5; }
		article a { margin-top: auto; color: var(--plum); font-weight: 700; text-decoration: none; }
		article a:hover { color: var(--pink); }
		@media (max-width: 760px) { .articles { grid-template-columns: 1fr; } .page { padding-top: 18px; } header { margin-top: 35px; } }
	</style>
</head>
<body>
	<main class="page">
		<a class="back" href="../myphp/dashboard.php">← Retour au dashboard</a>
		<header>
			<small>COMPRENDRE SON CYCLE</small>
			<h1>Des articles pour prendre soin de soi</h1>
			<p>Des informations simples et concrètes pour mieux comprendre les phases du cycle, écouter son corps et adopter de bonnes habitudes au quotidien.</p>
		</header>
		<section class="articles" aria-label="Articles Flo">
			<article>
				<small>Nutrition</small>
				<h2>Bien manger pendant les différentes phases</h2>
				<p>Découvrez comment composer des repas équilibrés, soutenir votre énergie et mieux vivre les changements d'appétit au fil du cycle.</p>
				<a href="article.php?slug=nutrition-cycle">Lire l'article →</a>
			</article>
			<article>
				<small>Énergie</small>
				<h2>Comprendre ses variations d'énergie</h2>
				<p>Apprenez à adapter votre activité, votre repos et vos objectifs aux signaux de votre corps, sans culpabiliser.</p>
				<a href="article.php?slug=energie-cycle">Lire l'article →</a>
			</article>
			<article>
				<small>Bien-être</small>
				<h2>Soulager les symptômes avec douceur</h2>
				<p>Chaleur, hydratation, mouvement doux et repos : des pistes simples pour prendre soin de soi lorsque les règles sont inconfortables.</p>
				<a href="article.php?slug=symptomes-regles">Lire l'article →</a>
			</article>
		</section>
	</main>
</body>
</html>
