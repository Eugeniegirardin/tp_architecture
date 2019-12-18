<!doctype html>
<html>
<head>
  <title> TP ARCHITECTURE - COMMENTAIRES </title>
  <meta charset="utf-8">
</head>
<body>
  <fieldset>
    <form method="POST">
      <input type="text" name="nom" placeholder="Nom"><br>
      <textarea name="contenu" placeholder="Commentaire"></textarea><br>
      <input type="submit" value="Envoyer" name="envoyer">
    </fieldset>
  </form>

  <?php
  $lien=mysqli_connect("localhost","root","","tp");
  if(isset($_POST['envoyer']))
  {
    $nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
    $contenu=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['contenu'])));
    $req="INSERT INTO comment VALUES (NULL,'$nom','$contenu')";
    $res=mysqli_query($lien,$req);
    if(!$res)
    {
      echo "Erreur SQL:$req<br>".mysqli_error($lien);
    }
  }

  if(!isset($_GET['page']))
  {
    $page=1;
  }
  else
  {
    $page=$_GET['page'];
  }
  $commparpage=4;
  $premiercomm=$commparpage*($page-1);
  $req="SELECT * FROM comment ORDER BY id LIMIT $premiercomm,$commparpage";/* LIMIT dit ou je commence et combien j'en prends*/
  $res=mysqli_query($lien,$req);
  if(!$res)
  {
    echo "erreur SQL:$req<br>".mysqli_error($lien);
  }
  else
  {
    while($tableau=mysqli_fetch_array($res))
    {
      echo "<h2>".$tableau['nom']."</h2>";
      echo "<p>".$tableau['contenu']."</p>";
    }
  }

  $req="SELECT * FROM comment";
  $res=mysqli_query($lien,$req);
  if(!$res)
  {
    echo "Erreur SQL:$req<br>".mysqli_error($lien);
  }
  else
  {
    $nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un résultat.
    $nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier supérieur*/
    echo "<br> Pages : ";
    echo "<a href='commentaires.php?page=1'> </a>";
    echo "<a href='commentaires.php?page=".($page-1)."'> </a>";
    for($i=($page-1);$i<=($page+1);$i++)
    {

      if($i <=0){}

        else{
          if($i > $nbpages){}
            else{
              echo "<a href='commentaires.php?page=$i'> $i </a>";}

            }
          }
        }
        echo "<a href='commentaires.php?page=".($page+1)."'> </a>";
        echo "<a href='commentaires.php?page=$nbpages'> </a>";

        mysqli_close($lien);
        ?>
      </body>
      </html>
