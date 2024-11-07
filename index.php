<?php
$services = [
    "communication" => [
        "nom" => "Dupont",
        "prenom" => "Marie",
        "email" => "marie.dupont@entreprise.com"
    ],
    "rh" => [
        "nom" => "Martin",
        "prenom" => "Jean",
        "email" => "jean.martin@entreprise.com"
    ],
    "logistique" => [
        "nom" => "Bernard",
        "prenom" => "Lucie",
        "email" => "lucie.bernard@entreprise.com"
    ], 
    "technique" => [
        "nom" => "Bernard",
        "prenom" => "Lucie",
        "email" => "lucie.bernard@entreprise.com"
    ]
];

if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        
      // Récupérer les informations du fichier
      $fileTmpName = $_FILES['cv']['tmp_name'];  // Chemin temporaire du fichier sur le serveur
      $fileName = $_FILES['cv']['name'];         // Nom original du fichier
      $fileSize = $_FILES['cv']['size'];         // Taille du fichier en octets
      $fileType = $_FILES['cv']['type'];         // Type MIME du fichier
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $nom = $_POST['nom'];
      $email = $_POST['email'];
      $telephone = $_POST['telephone'];
      if(mb_strlen($telephone) <  10 || mb_strlen($telephone) > 10 )
      $service = $_POST['service'];
      $message = $_POST['message'];
      $linkedin = !empty($_POST['linkedin']) ? $_POST['linkedin'] : null;
      $portfolio = !empty($_POST['portfolio']) ? $_POST['portfolio'] : null;
      $disponibilite = $_POST['disponibilite'];
      
$content = ""; 
if(isset($_POST['inscription']) &&  $_POST['inscription'] == "Inscription"){
    extract($_POST); 
    //format de l'email :
      
      if(mb_strlen($prenom) < 1 || mb_strlen($prenom) > 30){
            $content .= '<div class="alert alert-danger" role="alert">Le prenom doit contenir entre 1 et 30 caractères !</div>';
      }
  
      if(mb_strlen($nom) < 1 || mb_strlen($nom) > 30){
            $content .= '<div class="alert alert-danger" role="alert">Le nom  de passe doit contenir entre 1 et 30 caractères !</div>';
      }

      $email =  filter_var($email, FILTER_VALIDATE_EMAIL);
      if(!$email){
          $content .= '<div class="alert alert-danger" role="alert">Email incorrect !</div>';
      }
      //verification telephone: 
      if(mb_strlen($telephone) <  10 || mb_strlen($telephone) > 10 ){
            $content .= '<div class="alert alert-danger" role="alert">Le numero doit contenir doit 10 caractères !</div>';
      }
}

}

$content = ""; 
if(isset($_POST['inscription']) &&  $_POST['inscription'] == "Inscription"){
    extract($_POST); 
    //format de l'email :
      
      if(mb_strlen($prenom) < 1 || mb_strlen($prenom) > 30){
            $content .= '<div class="alert alert-danger" role="alert">Le prenom doit contenir entre 1 et 30 caractères !</div>';
      }
  
      if(mb_strlen($nom) < 1 || mb_strlen($nom) > 30){
            $content .= '<div class="alert alert-danger" role="alert">Le nom  de passe doit contenir entre 1 et 30 caractères !</div>';
      }

      $email =  filter_var($email, FILTER_VALIDATE_EMAIL);
      if(!$email){
          $content .= '<div class="alert alert-danger" role="alert">Email incorrect !</div>';
      }
      //verification telephone: 
      if(mb_strlen($telephone) <  10 || mb_strlen($telephone) > 10 ){
            $content .= '<div class="alert alert-danger" role="alert">Le numero doit contenir doit 10 caractères !</div>';
      }
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {   // Vérification si le formulaire a été soumis
    
      $email = $_POST['email'];
      $service = $_POST['service'];
      $nom = $_POST['nom'];    // Récupération des données du formulaire
      
      //Préparation de l'email de confirmation pour le candidat :
      
      $subjectCandidat = "Email de confirmation de votre inscription";  // Objet du mail / Sujet de l'email de confirmation pour le candidat
      $headersCandidat = "From: recrutement@votreentreprise.com";       // En-têtes, ici pour définir l'expéditeur.
      $messageCandidat = "Bonjour $nom,\n\nMerci de votre inscription. Nous avons bien reçu votre candidature pour le service '$service'.\nNous sommes ravis de vous compter parmi nous et nous vous contacterons bientôt pour la suite.\n\nCordialement,\nL'équipe Recrutement";  // Corps de l'email.
  
      // Envoi de l'email de confirmation au candidat
      mail($email, $subjectCandidat, $messageCandidat, $headersCandidat);
  
      // Informations à inclure dans l'email pour le responsable du service
      $subjectService = "Nouvelle candidature pour le service '$service'"; // Objet du mail
      $headersService = "From: recrutement@votreentreprise.com"; // En-têtes, ici pour définir l'expéditeur.
      $messageService = "Bonjour,\n\nUne nouvelle candidature a été soumise pour le service '$service'.\n\nNom du candidat : $nom\nEmail du candidat : $email\n\nVeuillez prendre connaissance de cette candidature et prendre les mesures nécessaires.\n\nCordialement,\nL'équipe Recrutement";
  
      // Envoi de l'email au responsable du service sélectionné
      // Par exemple, les responsables peuvent être définis dans un tableau (voir ci-dessous)
      $responsables = [
          'communication' => 'communication@votreentreprise.com',
          'rh' => 'rh@votreentreprise.com',
          'logistique' => 'logistique@votreentreprise.com',
          'technique' => 'technique@votreentreprise.com'
      ];
  
      // Vérifier si un email existe pour le service sélectionné
      if (isset($responsables[$service])) {
          $responsableEmail = $responsables[$service];
          mail($responsableEmail, $subjectService, $messageService, $headersService);
      } else {
          echo "Service non reconnu.";
      }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Formulaire de Candidature</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
        . error-message {
            color: red;
            font-size: 2px;
            margin-top: 2px;
        }
      </style>
      <?php
            $errors = [];
            $prenom = $nom = $email = $telephone = $service = $cv = $message = $linkedin = $portfolio = $disponibilite ="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  // Validation du prénom
                  if (empty($_POST["prenom"])) {
                        $errors['prenom'] = "Le prénom est requis.";
                  } else {
                        $prenom = htmlspecialchars($_POST["prenom"]);
                  }

                  // Validation du nom
                  if (empty($_POST["nom"])) {
                        $errors['nom'] = "Le nom est requis.";
                  } else {
                        $nom = htmlspecialchars($_POST["nom"]);
                  }

                  // Validation de l'email
                  if (empty($_POST["email"])) {
                        $errors['email'] = "L'email est requis.";
                  } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = "Format d'email invalide.";
                  } else {
                        $email = htmlspecialchars($_POST["email"]);
                  }

                  // Validation du téléphone
                  if (empty($_POST["telephone"])) {
                        $errors['telephone'] = "Le téléphone est requis.";
                  } else {
                        $telephone = htmlspecialchars($_POST["telephone"]);
                  }

                  // Validation du service
                  if (empty($_POST["service"])) {
                        $errors['service'] = "Veuillez sélectionner un service.";
                  } else {
                        $service = htmlspecialchars($_POST["service"]);
                  }

                  // Validation du CV
                  if (empty($_FILES["cv"]["name"])) {
                        $errors['cv'] = "Le CV est requis.";
                  } elseif (pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION) !== 'pdf') {
                        $errors['cv'] = "Le CV doit être au format PDF.";
                  }

                  // Validation du message de motivation
                  if (empty($_POST["message"])) {
                        $errors['message'] = "Le message de motivation est requis.";
                  } else {
                        $message = htmlspecialchars($_POST["message"]);
                  }

                  // Validation de la disponibilité
                  if (empty($_POST["disponibilite"])) {
                        $errors['disponibilite'] = "La date de disponibilité est requise.";
                  } else {
                        $disponibilite = htmlspecialchars($_POST["disponibilite"]);
                  }
            }
            ?>
<body>

      <div class="container my-5">
      <?= $content; ?>
      <?php if (empty($content) && isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') : ?>
      <?php endif; ?>
            <h2 class="mb-4">Formulaire de Candidature</h2>
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">

                  <!-- Prénom et Nom -->
                  <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"  value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ""; ?>" >
                  </div>

                  <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom"  value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ""; ?>" >
                  </div>

                  <!-- Email -->
                  <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"  value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ""; ?>" >
                  </div>

                  <!-- Téléphone -->
                  <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone"  value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ""; ?>">
                  </div>

                  <!-- Préférence de réception de CV -->
                  <div class="mb-3">
                        <label for="service" class="form-label">Service de transmission du CV</label>
                        <select class="form-select" id="service" required>
                              <option value="communication">Service communication</option>
                              <option value="rh">Service ressources humaines</option>
                              <option value="logistique">Service logistique</option>
                              <option value="technique">Service technique</option>
                        </select>
                  </div>

                  <!-- CV Upload -->
                  <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                              <label for="cv" class="form-label">CV (format PDF)</label>
                              <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
                        </div>
                  </form>

                  <!-- Message de motivation -->
                  <div class="mb-3">
                        <label for="message" class="form-label">Message de motivation</label>
                        <textarea class="form-control" id="message" rows="5"
                              placeholder="Parlez-nous de vous, de vos motivations, et de ce qui vous attire dans ce poste."
                              required></textarea>
                  </div>



                  <!-- LinkedIn -->
                  <div class="mb-3">
                        <label for="linkedin" class="form-label">Lien LinkedIn (optionnel)</label>
                        <input type="url" class="form-control" id="linkedin" name="linkedin"
                              placeholder="https://linkedin.com/in/votreprofil">
                  </div>

                  <!-- Portfolio -->
                  <div class="mb-3">
                        <label for="portfolio" class="form-label">Lien vers votre portfolio (optionnel)</label>
                        <input type="url" class="form-control" id="portfolio" name="portfolio"
                              placeholder="https://votreportfolio.com">
                  </div>

                  <!-- Disponibilité -->
                  <div class="mb-3">
                        <label for="disponibilite" class="form-label">Disponibilité</label>
                        <input type="date" class="form-control" id="disponibilite" name="disponibilite" required>
                  </div>

                  <!-- Bouton de soumission -->
                  <button type="submit" class="btn btn-primary">Envoyer la Candidature</button>
            </form>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>