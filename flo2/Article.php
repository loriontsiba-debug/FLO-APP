<?php 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Article.css">
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
                  <li><a href="Article.php">Articles</a></li>
               </ul>
        </nav>
      <div class="validation">
        <button class="bt1" ><a href="\Authentification\connec.php">Connexion</a></button>
         <button class="bt2"><a href="\Authentification\inscri.php">Commencer gratuitement</a></button>
      </div>
      </section >
      <section class="hero">
           <section class="lect">
                <div class="lect1">
                      <p>Articles</p>
                      <h2>Approfondissez vos connaissances</h2>
                </div>
                <div class="lect2">
                  <button type="submit"  class="but"><a href="">Tous les articles <span>→</span></a></button>
                </div>
        </section>
        <section class="art">
                <article class="art1">
                        <div class="art11">
                            <img src="./asset/OIP.webp" alt="" width="350px" height="350px">
                        </div>
                        <div class="art12">
                            <p><span>Fertilité</span></p>
                            <h3>Comprendre votre fenêtre fertile</h3>
                            <p>5 min de lecture</p>
                        </div>
                </article>
                <article class="art1">
                        <div class="art11">
                            <img src="./asset/blog-lactose-intolerantie-1-850x400.webp" alt="" width="350px" height="350px">
                        </div>
                        <div class="art12">
                            <p><span>Bien-être</span></p>
                            <h3>A L'impact du sommeil sur votre cycle</h3>
                            <p>4 min de lecture</p>
                        </div>
                </article>
                <article class="art1">
                        <div class="art11">
                             <img src="./asset/_d3e1c6e6-828c-44e8-bdad-c9ae6374565e.jpeg" alt="" width="350px" height="350px">
                        </div>
                        <div class="art12">
                            <p><span>Nutrition</span></p>
                            <h3>L'Alimentation et les règles douloureuses </h3>
                            <p>6 min de lecture</p>
                        </div>
                </article>
        </section>
      </section>
    </header>
    <main>
     <section class="container">
        <div class="circle1">
          <P class="p1">Commencez aujourd'hui</P>
          <h2>Votre santé mérite une attention <span class="cool">sincère et continue</span></h2>
          <p class="p2">Rejoignez les 12 000 femmes qui suivent leur cycle avec Flo. Gratuit, sécurisé, sans publicité.</p>
          <div class="circle10">
            <button class="but1"><a href="\Authentification\inscri.php">Créer un compte gratuit</a></button>
            <button class="but2"><a href="\Authentification\Connec.php">Accèder à l'app</a></button>
            <p class="p3">Aucune carte bleue · Données chiffrées · Sans engagement</p>
        </div>
        </div>
       
     </section>
      <div class="circle2">

        </div>
        <div class="circle3">
         
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
</body>
<script>
const burger = document.getElementById('burger');
const menu = document.getElementById('menu');

burger.onclick = () => {
  menu.classList.toggle('active');
  burger.classList.toggle('active');
}
</script>
</html>