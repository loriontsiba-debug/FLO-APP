<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Témoignage.css">
    <link rel="stylesheet" href="asset/">
</head>
<body>
    <header>
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
        <div id="container">
            <section class="témoins">
                    <p>Témoignages</p>
                    <h1>Ce qu'elles en disent</h1>
                    <p><span>Des milliers de femmes font déjà confiance à Flo chaque jour.</span></p>
            </section>
            <section class="avis">
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Flo m'a vraiment aidée à comprendre mes cycles irréguliers. En 3 mois, j'ai pu anticiper mes règles avec une précision que je n'aurais pas cru possible."</p>
                    <div class="flex">
                        <article class="art1">
                           <p>A</p> 
                        </article>
                        <article class="art2">
                            <p>Marie D.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
                 </div>
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Grâce à Flo, je suis maintenant en mesure de planifier mon calendrier avec une grande exactitude. C'est un outil inestimable pour ma vie quotidienne."</p>  
                        <div class="flex">
                        <article class="art1">
                           <p>P</p> 
                        </article>
                        <article class="art2">
                            <p>Marie D.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
                 </div>
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Flo m'a permis de mieux comprendre mon corps et de prendre en charge ma santé reproductive de manière proactive."</p>
                    <div class="flex">
                        <article class="art1">
                           <p>F</p> 
                        </article>
                        <article class="art2">
                            <p>Marie D.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
                 </div>
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Flo m'a vraiment aidée à gérer mes symptômes et à améliorer ma qualité de vie. C'est une application indispensable pour les femmes qui veulent prendre soin de leur santé."</p>
                      <div class="flex">
                        <article class="art1">
                           <p>M</p> 
                        </article>
                        <article class="art2">
                            <p>Melanie M.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
                 </div>
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Grâce à Flo, j'ai pu identifier mes schémas de cycle et prendre des décisions éclairées concernant ma santé reproductive. C'est un outil précieux pour la gestion personnelle de la santé." </p>
                      <div class="flex">
                        <article class="art1">
                           <p>T</p> 
                        </article>
                        <article class="art2">
                            <p>Teddy D.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
                 </div>
                 <div class="items">
                    <span>★★★★★</span>
                    <p>"Flo m'a vraiment aidée à comprendre mes cycles irréguliers. En 3 mois, j'ai pu anticiper mes règles avec une précision que je n'aurais pas cru possible."</p>
                     <div class="flex">
                        <article class="art1">
                           <p>K</p> 
                        </article>
                        <article class="art2">
                            <p>Marcelo k.</p>
                            <p>pointe-noire</p>
                        </article>
                        
                    </div>
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