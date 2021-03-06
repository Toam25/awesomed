<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\BoutiqueRepository;
use Doctrine\ORM\Query\AST\Functions\LowerFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryService
{

   static $category;
   private $articleRepository;
   private $typeBoutique;
   private $utilsService;

   public function __construct(ArticleRepository $articleRepository,UtilsService $utilsService)
   {
      $this->articleRepository = $articleRepository;
      $this->typeBoutique = "high-tech";
      $this->utilsService=$utilsService;
   }

   public function getAddButton(array $options,string $class){
      $button ="";
      foreach ($options as $option) {
         $button.='<button id="' .$this->utilsService->getSlug($option['name']). '"class="' . $class . '">'.$option['name'].'</button>';
      }
      return $button;
   }
   public function getCategoryForArticle($boutique)
   {
      $list = [];

      $article = $this->articleRepository->findAllArticleByBoutique($boutique);
      $allCategory = $this->getAllCategory($boutique->getType());

      for ($i = 0; $i < sizeof($article); $i++) {
         if (!in_array($article[$i]->getCategory(), $list)) {
            foreach ($allCategory as $values) {
               foreach ($values as $key => $value) {
                  if (in_array($article[$i]->getCategory(), $value)) {
                     $is_exist = false;
                     foreach ($list as $keylist => $valuelist) {
                        if (array_key_exists($key, $valuelist)) {
                           $is_exist = true;
                        }
                     }
                     if ($is_exist) {
                        if (!in_array($article[$i]->getCategory(), $list[$keylist][$key])) {
                           array_push($list[$keylist][$key], $article[$i]->getCategory());
                        }
                     } else {
                        array_push($list, [$key => [$article[$i]->getCategory()]]);
                     }
                  }
               }
            }
         }
      }
      $marque = [];

      for ($i = 0; $i < sizeof($article); $i++) {
         if (!in_array($article[$i]->getMarque(), $marque)) {
            array_push($marque, $article[$i]->getMarque());
         }
      }

      return [
         'marque' => "", //$this->htlmMarque($marque),
         'categorie' => $this->htlmCategory($list)
      ];
   }
   public function getCategory()
   {
      $type = strtolower($this->typeBoutique);
      if (in_array($type, ['high-tech', 'art malagasy', 'mode'])) {
         return $this->getAllCategory($this->typeBoutique);
      } else {
         return [];
      }
   }
   public function getAllCategory($type)
   {
      $array = [
         'high-tech' => [
            'T??l??phone' => $this->getAttribut('T??l??phone'),
            'Accessoires' => $this->getAttribut('Accessoires'),
            'Tv' => $this->getAttribut('TV'),
            'Video projecteur' => $this->getAttribut('Video projecteur'),
            'Son' => $this->getAttribut('Son'),
            'Phone et Cam??ra' => $this->getAttribut('Phone et cam??ra'),
            'Tous les accessoire' => $this->getAttribut('Tous les accessoires'),
            'Mat??riels Informatiques' => $this->getAttribut('Mat??riel informatiques'),
            'Diagnostiques' => $this->getAttribut('Diagnostiques'),
            'Systeme domotique' => $this->getAttribut('Syst??me domotique'),
            'Impression' => $this->getAttribut('Impression'),
         ]

      ];


      return $array[strtolower($type)];
   }
   public function getAttribut($categorie_menu)
   {
      $option = [];
      $listOption = [];
      //telefonie
      if ($categorie_menu == "Accessoires") {

         $listOption = ['Coques', 'Batteries, Batteries externes', 'Ecouteurs', 'Enceintes bluetooth', 'Chargeurs', 'Oreillette bluetooth', 'Kits mains libres', 'Protection ??cran', 'Carte m??moire', 'Casque'];
      }

      if ($categorie_menu == "T??l??phone") {
         $listOption = ['T??l??phone fixe', 'T??l??phone avec touche', 'Smartphone', 'I-phone'];
      }
      //image et son
      if ($categorie_menu == "TV") {
         $listOption = ['TV LED-LCD', 'TV 4K-UHD', 'Support TV', 'TV connect??e', 'Smart TV'];
      }
      if ($categorie_menu == "Video projecteur") {

         $listOption = ['HD Ready', 'Full HD', '4K/UHD', 'Accessoires'];
      }
      if ($categorie_menu == "Son") {

         $listOption = ['Casque auto', 'Enceintes bleutooth, MP3, MP4', 'Radio', 'Dictaphone', 'Hifi', 'Bare de son'];
      }
      if ($categorie_menu == "Phone et cam??ra") {

         $listOption = ['Flash photo', 'Filtre', 'Cam??scope cam??ra', 'Objectif reflex', 'Objectif cam??ra', 'GoPro', 'Autre'];
      }
      if ($categorie_menu == "Tous les accessoires") {

         $listOption = ['C??ble et connectique', 'Accessoires audio et video', 'Accessoires photos', 'Accessoires cam??ra'];
      }
      //informatique
      if ($categorie_menu == "Mat??riels informatiques") {

         $listOption = ['Ordinateurs de bureau', 'ordinateurs portables', 'Tablette', 'Univers gaming', 'Composants - p??rif??rique', 'Stockage', 'R??seaux'];
      }
      if ($categorie_menu == "Diagnostiques") {

         $listOption = ['Hardware', 'Software'];
      }
      //impression
      if ($categorie_menu == "Impression") {

         $listOption = ['Imprimante jet d\'encre', 'Imprimante laser', 'Scaner', 'Cartouches', 'Toners'];
      }

      if ($categorie_menu == "Syst??me domotique") {

         $listOption = ['Motorisation', 'portails et volets', 'Accessoires', 'Interphone video', 'Alarme-D??tecteur', 'Cam??ra de surveillance', 'S??curit??  incendie'];
      }

      foreach ($listOption as $k => $v) {
         $option[$v] = $v;
      }


      return $option;
   }
   private function htlmCategory(array $list)
   {

      $html = "<div>";
      $html .= "<label for='search' class=' '>Recherche</label>";
      $html .= "<input id='search' type='text' placeholder='Recherche' name='q' class='form-control' />";
      $html .= "<label for='min_price ' class=' '>Prix</label>";
      $html .= "<div class='containt_price '>";
      $html .= "<input type='number' placeholder='min' name='min_price' class='form-control' />";
      $html .= "<input type='number' placeholder='max' name='max_price' class='form-control'/>
       </div>";

      $html .= "</div>";
      $html .= "<ul>";
      for ($i = 0, $j = 0; $i < sizeof($list); $i++) {
         foreach ($list[$i] as $keys => $values) {
            $html .= "<label for='category" . $j . "' class=' form-check-label '>" . ucfirst(mb_strtolower($keys, 'UTF-8')) . "</label>";
            $html .= "<ul class=''>";
            foreach ($values as $key => $value) {
               $j++;
               $html .= "<li class=''>";
               $html .= "<input id='category" . $j . "' class='' type='checkbox' name='category[]' value='" . $value . "'><label for='category" . $j . "'class='form-check-label'>" . ucfirst(mb_strtolower($value, 'UTF-8')) . "</label>";
               $html .= "<li>";
            }
            $j++;
            $html .= "</ul>";
         }
      }
      $html .= "</ul>";
      return $html;
   }

   public function htlmMarque(array $marque)
   {
      if (sizeof($marque) > 0) {
         $html = "
        <label class=''>Marques :</label>
        <div>
        <ul>
        ";
         $j = 0;
         foreach ($marque as  $value) {
            $html .= "<li>";
            $html .= "<input id='marque" . $j++ . "' class='' type='checkbox' name='marque[]' value='" . $value . "'><label for='marque" . $j . "'class='form-check-label'>" . ucfirst(mb_strtolower($value, 'UTF-8')) . "</label>";
            $html .= "</li>";
         }
         $html .= "
        </ul>
        </div>";
      }
      return $html;
   }
   private  $type = [
      'Chemise', 'Jeans','Outils de jardin','Outillage ?? main', 'Outillage ??l??ctroportatif', 'Machines equipements', 'El??ctricit??', 'Quincallerie','Outils ?? main', 'Outils divers', 'Outils multifonctions', 'Outils ??l??ctriques', 'Accessoires', 'Electricit??', 'Pi??ces d??tach??es','Barettes', 'Bandeau', 'T-shirts', 'Polos', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Costumes', 'Vestes', 'Pantalons', 'Short', 'Bermudas', 'Tenues de Sports', 'Vetement de nuit', 'Impermeable', 'Maillots de Bains', 'Chaussettes', 'Ensemble', 'Jogging', 'Blousons', 'Derbies', 'Chaussures de ville', 'Slippers', 'Derbie', 'Basket', 'Bottes', 'Boots', 'Chaussons', 'Chaussures bateau', 'Chaussures de Securit??', 'Chaussures de sports', 'Espadrilles', 'Mocassins', 'Mulle', 'Sabot', ' Sandales', 'Tongs', 'Cale??o', 'Boxeur', 'Slips', 'Shorty', 'Jock strap', 'Chaussette', 'Pantie', 'Robe de ceremonie', 'Robe de mari??e', 'Robe de fian??aille', 'Cardigans', 'Body', 'Blouse', 'D??bardeur', 'Tailleurs ', 'Jupes', 'Salopettes', 'Short et Bermudas', 'Leggins', 'Robes', 'Combi-short', 'Collants', 'V??tements de Grossess', 'V??tement de nuit', 'V??tement de Sports', 'Imperm??able', 'Maillots de Bains', 'Ballerines', 'Baskets', 'Botte', 'Dentelle c??t??', 'Tanga', 'Boxer',  'Accessoires', 'Bas', 'Jarreti??res', 'Bodys', 'Bustiers', 'Corsets', 'Caracos', 'Combinaisons', 'Jupons', 'Culottes', 'Shorties', 'Strings', 'Ensembles de Lingeries', 'Lingeries', 'Nuisettes', 'Deshabill??s', 'V??tements Th??rmiques', 'Soutiens Gorges', 'Pantalon', 'Cardigans', 'Jean', 'Bermuda', 'Sous v??tements', 'Joggins', 'Salopette', 'Sweat-Shirt', 'Tailleur', 'Escarpins', 'Babies', 'Baskets mode', 'Couverture B??b??', 'Peluches', 'Veste', 'Salopettes', 'Combinaison', 'Sweat-Shirt', 'Grenoulli??re', 'Pyjamas', 'Couverture B??b??', 'Botillon', 'Sac ?? main', 'Sac ?? dos', 'Sac de voyage', 'Sac bandouli??re', 'Portefeuilles et porte-cartes', 'Cabas', 'Pochettes', 'Sacs portes ??paule', 'Alliances', 'Montre', 'Parure de bague', 'Boutons de manchette', 'Bagues', 'Pendentifs', 'Boucles d\'oreilles', 'Bracelet', 'Broches', 'Colliers', 'Sautoir', 'Parures de bijoux', 'Cha??ne', 'Citrine', 'Quartz', 'Jade', 'Rubis', 'Diamant', 'Em??raude', 'Vannerie', 'Poterie', 'Miniature', 'Fruits / corbeilles ?? pain', 'Sets de table en bambou', 'Bo??te ?? ??pices', 'Cadre photo', 'Support de pot de fleur', 'Pots de fleur', 'D??coration murale', 'Objet design fer forge', 'Embout', 'Montre mural en fer forg??', 'Bougeoir', 'Photophore', 'Applique & Luminaires', 'Cornes de z??bu', 'Literie', 'Penderie', 'Table', 'Porte cintre', 'Chaise', 'Table avec chaise', 'Range chaussures', 'Sacs', 'Panier', 'Chapeaux', 'Nappe', 'Smoc', 'Couvre lit', 'Richelieu', 'Crochet', 'Ch??le', 'Malabary', 'Lambamena', 'Sacs', 'Panier', 'Chapeaux', 'Noeud', 'Serre t??te', 'Pince ?? cheveux', 'Brousse', 'Elastique de cheveux', 'bandeau', 'Boucle d???oreilles', 'Colliers', 'Pendentif', 'Gourmettes', 'Alliances', 'Boutons de manchette', 'Bracelets', 'Bague', 'Parure de bague', 'Chaine', 'Sautoir', 'Montres', 'Sacs bowling', 'Ceinture', 'Gants', 'Casquettes', 'Echarpes', 'Foulards', 'Bonnets', 'Headband', 'Cravates', 'Lunettes', 'Petite Flowerbox', 'Moyenne Fowerbox', 'Grande Flowerbox', 'Flowerbox personnalis??e', 'Eaux de toilettes', 'D??odorants homme', 'D??odorants femme', 'Parfums homme', 'Parfum femme', 'Eaux de Cologne', 'Huile essentielle', 'Huile v??g??tale', 'Huile massage', 'Produits naturels amincissant', 'Crayons et eyeliners', 'Mascaras', 'Ombres ?? paupi??res', 'Palettes et coffrets', 'Blush et poudres', 'Fonds de teint et BB cr??me', 'Rouges ?? l??vres', 'Primers et correcteurs', 'pilateurs sourcils', 'D??pilatoires', 'Accessoires maquillage', 'Anti-rides et anti-??ges', 'Masques et gommages', 'Nettoyants et d??maquillants', 'Purifiants et matifiants', 'Soins des l??vres et des yeux', 'Cr??mes', 'Lotions', 'Baume', 'Emulsions', 'Huiles pour la peau', 'Produits de bronzage', 'produits pour le rasage', 'Produits d\???hygi??ne dentaire et buccale', 'Produits d???hygi??ne  intime externe', 'Bain & douche', 'Savons de toilette', 'Soins hydratants et nourrissants', 'Base protectrice Clean', 'Vernis', 'DDissolvant', 'Faux ongles', 'Lime', 'Pack de produits', 'Vaporisateurs', 'Fixateurs', 'Shampooings', 'Apr??s-shampooings', 'Masques', 'Gel', 'Colorants', 'Produit pour l\'ondulation', 'Produit de coiffage', 'Huiles', 'Soins traitements', 'Coques', 'Batteries, Batteries externes', 'Ecouteurs bleutooth', 'Enceintes bleutooth', 'Chargeurs', 'Oreillette bleutooth', 'Kits mains libres', 'Protection ecran', 'Carte m??moire', 'T??l??phone fixe', 'T??l??phone avec touche', 'Smartphone', 'I-phone', 'TV LED-LCD', 'TV 4K-UHD', 'Support TV', 'TV connect??e', 'Smart TV', 'HD Ready', 'Full HD', '4K/UHD', 'Accessoires', 'Casque auto', 'Enceintes bleutooth, MP3, MP4', 'Radio', 'Dictaphone', 'Hifi', 'Bare de son', 'Flash photo', 'Filtre', 'Cam??scope cam??ra', 'Objectif reflex', 'Objectif cam??ra', 'GoPro', 'Autre', 'C??ble et connectique', 'Accessoires audio et video', 'Accessoires photos', 'Accessoires cam??ra', 'Ordinateurs de bureau', 'ordinateurs portables', 'Tablette', 'Univers gaming', 'Composants - p??rif??rique', 'Stockage', 'R??seaux', 'Hardware', 'Software', 'Imprimante jet d\'encre', 'Imprimante laser', 'Scaner', 'Cartouches', 'Toners', 'Motorisation', 'portails et volets', 'Accessoires', 'Interphone video', 'Alerme-D??tecteur', 'Cam??ra de surveillance', 'S??curit??  incendie', 'Comprime', 'Gellule', 'Liquide', 'Injectable', 'Visage', 'Corps', 'Cheveux', 'Autres', 'B??b??', 'Enfant', 'Femme enceinte', 'adulte', 'Rectale', 'Plantes m??dicinales', 'Produits de sant?? naturels', 'Compl??ment alimentaire', 'Argile verte', 'Huile d\'amande douce ', 'Huile d\'arachide', 'Femme enceinte', 'Huile d\'argan', 'Huile d\'avocat', 'Huile de baobab', 'Huile de calendula', 'Huile de cameline', 'Huile de coco', 'Huile de colza', 'Huile de germe de bl??', 'Beurre de Karit??', 'Huile de Moutarde', 'Huile d\'Olive', 'Huile de Palme', 'Huile de Ricin', 'Huile de Tournesol', 'Huile de S??same', 'Huile de Lorenzo', 'Huile de poisson'
   ];

   public function getTypeArticle(): ?array
   {
      $type = $this->type;
      $output = array();
      for ($i = 0; $i < sizeof($type); $i++) {
         $output[$type[$i]] = $type[$i];
      }
      return $output;
   }

   public function getNameMenu($categorie){
      
      switch ($categorie) {
         case 'outils_de_jardin':
             return 'Outils de jardin';
             break;
         case 'outillages':
             return 'Outillages';
             break;
         case 'outillages_pro':
             return 'Outillages pro';
             break;
         case 'habillement_homme':
             return 'Habillement homme';
             break;
         case 'habillement_femme':
             return 'Habillement femme';
             break;
         case 'habillement_enfant':
             return 'Habillement enfant';
             break;
         case 'habillement_bebe':
             return 'Habillement b??b??';
             break;
         case 'acc_parfums':
             return 'Parfums';
             break;
         case 'acc_beaute_bio':
             return 'Beaut??_bio';

         case 'acc_cosmetique':
             return 'Cosmetique';

             break;
         case 'bijoux_pierre':
             return 'Bijoux et pierre pr??cieuse';
             break;
         case 'accessoire_decoration':
             return 'Accessoire d??coration';
             break;
         case 'maroquineries':
             return 'Maroquineries';
             break;
         case 'produit_soie_raphia':
             return 'Produit en soie, raphia';

             break;
         case 'acc_cheveux':
             return 'Accessoire cheveux';
             break;
         case 'acc_bijoux_montre':
             return 'Bijoux et montre';
             break;
         case 'acc_sacs_maroquinerie':
             return 'Sacs, maroquinerie';
             break;
         case 'acc_flowerbox':
             return 'Fashion +';
             break;


         case 'telephone':
             return 'T??l??phone';
             break;
         case 'Accessoires_tele':

             return 'Accessoire t??l??';

             break;
         case 'tous_accessoires':

             return 'Tous les accessoires';

             break;
         case 'systeme_domotique':

             return 'Syst??me domotique';

             break;
         case 'impression':

             return 'Impression';

             break;

         case 'accessoires':
             return 'Accessoire';
             break;

         case 'matierels_informatique':
             return 'Mati??riel informatique';
             break;
         case 'diagnotiques':
             return 'Diagnostique';
             break;
         case 'tv':
             return 'Tv';
             break;
         case 'videoprojecteur':
             return 'Video projecteur';

             break;
         case 'son':
             return 'Son';
             break;
         case 'photo_et_camera':
             return 'Photo et cam??ra';
             break;

         case 'huille_essentiel_et_vegetale':
             return 'Huille essentiel et v??getale';
             break;
         case 'voies_orale':
             return 'Voies orale';
             break;
         case 'injectable':
             return 'Injectable';
             break;
         case 'dermique':
             return 'Dermique';
             break;
         case 'inhalee':
             return 'Inhal??e';
             break;
         case 'rectale':
             return 'Rectale';
             break;
         default:
             return '.....Page introuvable';
             break;
     }
   }
}
