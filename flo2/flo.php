<?php
$nb_utilisateurs = 1542; 
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="flo.css">
    <link rel="stylesheet" type="" href="./asset/">
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
      <section class="hero">
            <div class="lectur">
                        <div class="cycle">
                            <button>Suivi du cycle féminin</button>
                        </div>
                        <div class="learn">
                            <h1>Comprenez votre corps,<br> <span>cycle après cycle</span></h1>
                        </div>
                        <div class="para">
                            <P>Flo vous accompagne dans le suivi de votre cycle <br> menstruel — calendrier,symptomes,prédictions <br>d'ovulation et articles éducatifs réunis en un seul outil.</P>
                        </div>
                        <div class="bt">
                            <button class="bt3">essayer gratuitement</button>
                            <button class="bt4">voir la demo</button>
                        </div>
                       <div class="compteur">
                               <strong><span>+</span></strong> <var id="compteur" data-target="<?php echo $nb_utilisateurs ;?>" ></var>
                                <var id="var1">98 <span>%</span></var>
                                <var id="var2">4,9 <span>★</span></var>
                        </div>
            </div>
            <div class="visuel">
                        <div class="image">
                            <p><img src="asset/_a0d1107a-45f0-404f-85e7-12c90fb34ec7.jpeg" alt="" width="500px" height="500px"></p>
                        </div>
                        <article class="flottement1">
                            <div class="fl1">
                                <P>jour du cycle</P>
                                <var>14</var>
                                <p class="ovul">phase ovulatoire</p>
                             </div>
                             <div class="cercle">
                                    <svg viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="#eee" stroke-width="10"/>
                                        <circle cx="50" cy="50" r="45" fill="none" stroke="#007bff" stroke-width="10"
                                        stroke-dasharray="283" stroke-dashoffset="70.75"/>
                                    </svg>
                                    <span>75%</span>
                            </div>

                        </article>
                        <article class="flottement2">
                            <p>prochaine règles</p>
                            <p>dans<var>14</var>jours</p>
                            <p><var>12</var>septembre</p>
                        </article>
            </div>
      </section>
    </header>

    <main>
       <section class="section1">
          <p>Fonctionnalités</p>
          <h1>Tout ce dont vous avez <br>besion,réuni en un seul <br>endroit</h1>
          <p>une application pensée par des femmes.Simple à <br>utiliser,puissante dans ses analyses.</p>
       </section>
       <section class="section2">
          <div>
             <h2>Calendrier interactif</h2>
             <p>Visualisez votre cycle mois par mois avec vos règles, ovulation et fenêtre fertile clairement indiqués.</p>
          </div>
          <div>
             <h2>Journal quotidien</h2> 
             <p>
                Enregistrez humeur, symptômes, sommeil et flux en quelques secondes. Votre santé documentée au quotidien.
             </p>
          </div>
          <div>
            <h2>Prédiction intélligentes</h2>
            <p>
                Notre algorithme analyse vos cycles passés pour anticiper vos prochaines règles et jours fertiles avec précision.
            </p>
          </div>
          <div>
            <h2>Articules éducatifs</h2>
            <p>
                Accédez à des contenus vérifiés par des professionnels de santé pour mieux comprendre votre corps.   
            </p>
          </div>
          <div>
            <h2>Rappels personnalisés</h2>
            <p>
                Configurez des alertes pour votre journal quotidien, votre fenêtre fertile ou vos médicaments.
            </p>
          </div>
          <div>
            <h2>Données privés et sécurisées</h2>
            <p>
                Vos données sont chiffrées et ne sont jamais revendues. Votre santé vous appartient.
            </p>
          </div>
       </section> 
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
              const compteur = document.getElementById('compteur');
              const target = +compteur.getAttribute('data-target'); // 1542
              let started = false;

              function animerCompteur() {
                if(started) return; // pour lancer qu'une fois
                started = true;

                let count = 0;
                const vitesse = 50; // plus c'est petit plus ça va vite

                const update = () => {
                  count += target / vitesse;
                  if(count < target) {
                    compteur.innerText = Math.ceil(count);
                    setTimeout(update, 20);
                  } else {
                    compteur.innerText = target;
                  }
                }
                update();
              }

              // Lancer l'animation quand on voit le compteur en scrollant
              const observer = new IntersectionObserver(entries => {
                if(entries[0].isIntersecting) {
                  animerCompteur();
                }
              });
              observer.observe(compteur);
</script>


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