<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Comment.css">
    <link rel="stylesheet" href="asset/">
</head>
<body>
    <header>
          <section class="first">
      <div class="flo">
        <a href="flo.php"><p>Flo</p></a>
      </div>  
          <button class="burger" id="burger">
                <span></span>
                <span></span>
                <span></span>
         </button>
        <nav id="menu">
               <ul>
                  <li><a href="flo.php">Fonctionnalités</a></li>
                  <li><a href="Comment ça marche.php">Comment ça marche</a></li>
                  <li><a href="Témoignage.php">Témoignage</a></li>
                  <li><a href="Articles.php">Articles</a></li>
               </ul>
        </nav>
      <div class="validation">
         <button class="bt1">Connexion</button>
         <button class="bt2">Commencer gratuitement</button>
      </div>
      </section >
    </header>
    <main>
        <div class="container">
        <section class="sect0">
           <p class="p1"> Comment ça marche</p>
           <h1>Simple à prendre en main,<br>puissant sur la durée</h1>
           <div>
             <h3><span>1.</span>Créez votre compte</h3>
             <p>Inscription en 30 secondes. Aucune carte bleue requise, accès immédiat à <br>toutes les fonctionnalités.</p>
           </div>
           <div>
             <h3><span>2.</span>Renseignez vos données initiales</h3>
             <p>Date de vos dernières règles, durée habituelle de votre cycle. Flo s'adapte<br> à votre historique.</p>
           </div>
           <div>
             <h3><span>3.</span>Suivez au quotidien</h3>
             <p>Quelques secondes chaque jour pour enregistrer votre humeur, symptômes et flux. <br>Le journal s'enrichit au fil du temps.</p>
           </div>
           <div>
             <h3><span>4.</span>Profitez des prédictions</h3>
             <p>Dès le deuxième cycle, nos prédictions s'affinent pour vous donner des estimations <br> précises de vos prochaines règles et jours fertiles.</p>
           </div>
           <div>
            <button id="but">commencer maintenant</button>
           </div>
        </section class="sect1">
        <section>
            <div><img src="asset/blog-lactose-intolerantie-1-850x400.webp" alt="" width="500px" height="500px"></div>
            <div class="apr">
              <p>précisions des prédictions</p>
              <span>94%</span>
              <h5>apres 3 cycles</h5>
            </div>
        </section>
        </div>
    </main>
    <footer>
         <section class="foot1">
           <div class="flo">
                 <a href="flo.php"><p>Flo</p></a>
                 <p>Application de suivi du cycle menstruel <br> — naturelle, professionnelle, conçue pour <br> vous.</p>
            </div>  
            <div class="p">
                  <p>Application</p>
                  <ul>
                    <li><a href="">Tableau de bord</a></li>
                    <li><a href="">Calendrier</a></li>
                    <li><a href="">journal</a></li>
                    <li><a href="">Articles</a></li>
                  </ul>
            </div> 
            <div class="p">
                  <p>Aide</p>
                  <ul>
                    <li><a href="">FAQ</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Politique de confidentialité</a></li>
                    <li><a href="">CGU</a></li>
                  </ul>  
            </div>
            <div class="p">
                    <p>Communauté</p>
                  <ul>
                    <li><a href="">Instagram</a></li>
                    <li><a href="">Newsletter</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Partenaires</a></li>
                  </ul>
            </div>
     </section>
     <section>
      <hr>
     </section>
     <section class="foot2">
          <div>
              <p>&copy2026.Tous droits réservés</p>
          </div>
          <div>
              <p>Fait avec <span>♥</span> pour toutes les femmes</p>
          </div>
     </section>
    </footer>
    
<script>
const burger = document.getElementById('burger');
const menu = document.getElementById('menu');

burger.onclick = () => {
  menu.classList.toggle('active');
  burger.classList.toggle('active');
}
</script>
</body>
</html>