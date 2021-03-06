<?php

namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TypeOptionMenuService extends AbstractController
{

   private $utilsService;
   public function __construct(UtilsService $utilsService)
   {
      $this->utilsService = $utilsService;
   }
   /**
    * @return  array
    */
   public function getTypeOptionMenu($typeMenu=null, $category = null, $sous_category = null)
   {   
      $utils = $this->utilsService;

  
      if($utils->getSlug($typeMenu) == "habillement"){
        $type = [
            'habillement'=>$this->getCategoryHabillement(),
        ];
      }
      elseif($utils->getSlug($typeMenu)=='accessoires'){
         $type =  [
             'accessoires'=>$this->getCategoryAccessoires()
          ];
      }
      elseif($utils->getSlug($typeMenu)=="beaute-et-bien-etre"){
        
         $type = [
            'beaute-et-bien-etre'=>$this->getCategoryBeauteEtBienEtre()
           
        ];
      }
      else{
         $type = [
            ////////informatique
            'high-tech' => $this->getCategoryHighTech(),
   
            ////////mode
            'mode' => $this->getCategoryMode(),
   
            ////////service
            'services' => $this->getCategoryServices(),
   
            //////////////maison
            'maison' => $this->getCategoryMaison()
   
         ];
      }
      
      

      if ($sous_category != null) {
         return $type[strtolower($typeMenu)][$utils->getSlug($category)]['sous_category'][$utils->getSlug($sous_category)] ?? [];
      } else if ($category != null) {
         return $type[strtolower($typeMenu)][$utils->getSlug($category)]['sous_category'] ?? [];
      }
      else if ($typeMenu!=null){
        
         return $type[strtolower($typeMenu)] ?? [];
      }

      return $type;
   }
   /**
    * return @array
    */
   public function getOption($option,string $type=""){
      $array = [];
       $utils= $this->utilsService;
      if($type==""){
         
          $categories = $this->getTypeOptionMenu();
          foreach ($categories as $keyc=> $category) {
            foreach ($category as $keys=>$sous_category) {
              foreach ($sous_category['sous_category'] as $key=>$_sous_category) {
                  if($option == $key){
  
                    return  [
                       'category'=>$keyc,
                       'sous_category'=>$sous_category['category'],
                       'name'=>$_sous_category['name'],
                       'option'=>$_sous_category['options']
                    ] ;
                  }
             }
            }
       }
      }
      else{
         $categories = $this->getTypeOptionMenu($utils->getSlug($type));
         
            foreach ($categories as $keys=>$sous_category) {
               
              foreach ($sous_category['sous_category'] as $key=>$_sous_category) {

                  if($option == $key){
                    return  [
                       'category'=>$utils->getSlug($type),
                       'sous_category'=>$sous_category['category'],
                       'name'=>$_sous_category['name'],
                       'option'=>$_sous_category['options']
                    ] ;
                  }
             }
            }
      }
      
     
      return $array;
   }
   public function getCategoryMaison()
   {
      return [
         "bricolage" => [
            'category' => 'Bricolage',
            'sous_category' => [
               "outillages" => [

                  'name' => 'Outillages',
                  'options' => [
                     'Outils ?? main', 'Accessoires', 'Outils divers', 'Outils multifonctions', 'Outils ??l??ctriques', 'Pi??ces d??tach??es'
                  ]
               ]
            ]
         ],
         "professionnel" => [
            'category' => 'Professionnel',
            'sous_category' => [
               "outillages-pro" => [
                  'name' => 'Outillages Pro',

                  'options' => [
                     'Outillage ?? main', 'Outillage ??l??ctroportatif', 'Machines equipements', 'El??ctricit??', 'Quicallerie'
                  ]
               ]

            ]
         ],
         "jardinage" => [
            'category' => 'Jardinage',

            'sous_category' => [
               "outils-de-jardin" => [
                  'name' => 'Outils de jardin',

                  'options' => [
                     'Outils de jardin'
                  ]
               ]

            ]
         ]

      ];
   }
   public function getCategoryBeauteEtBienEtre()
   {
      return  [
         "parfumeries" =>
         [
            "category" => "Parfumeries",
            'sous_category' => [
               'parfumeries' => [

                  'name' => 'Parfumeries',
                  'options' => [
                     'Eaux de toilettes', 'D??odorants homme', 'D??odorants femme', 'Parfums homme', 'Parfum femme', 'Eaux de Cologne'
                  ]
               ]

            ]
         ],
         "beaute-bio" =>
         [
            "category" => "Beaut?? bio",
            'sous_category' => [
               'beaute-bio' => [

                  'name' => 'Beaut?? bio',
                  'options' => [
                     'Huile essentielle', 'Huile v??g??tale', 'Huile massage', 'Produits naturels amincissant'
                  ]
               ]

            ]
         ],
         "cosmetiques" =>
         [
            "category" => "Cosm??tiques",
            'sous_category' => [
               'soins-de-corps-et-visage' => [
                  'name' => 'Soins de corps et visage',
                  'options' => [
                     'Crayons et eyeliners', 'Mascaras', 'Ombres ?? paupi??res', 'Palettes et coffrets', 'Blush et poudres', 'Fonds de teint et BB cr??me', 'Rouges ?? l??vres', 'Primers et correcteurs', 'pilateurs sourcils', 'D??pilatoires', 'Accessoires maquillage ', 'Anti-rides et anti-??ges', 'Masques et gommages', 'Nettoyants et d??maquillants', 'Purifiants et matifiants', 'Soins des l??vres et des yeux', 'Cr??mes', 'Cr??me solaire', 'Lotions', 'Baume', 'Emulsions', 'Huiles pour la peau', 'produits de bronzage', 'produits pour le rasage', 'Produits d???hygi??ne dentaire et buccale', 'Produits d???hygi??ne  intime externe', 'Bain & douche', 'Savons de toilette', 'Soins hydratants et nourrissants'
                  ]
               ],
               'soins-des-ongles' => [

                  'name' => 'Soins des ongles',
                  'options' => [
                     'Base protectrice Clean', 'Vernis', 'Dissolvant', 'Faux ongles', 'Lime'
                  ]
               ],
               'soins-des-cheveux' => [

                  'name' => 'Soins des cheveux',
                  'options' => [
                     'Pack de produits', 'Vaporisateurs', 'Fixateurs', 'Shampooings', 'Apr??s-shampooings', 'Masques', 'Gel', 'Colorants', 'Produit pour l\'ondulation', 'Produit de coiffage', 'Huiles', 'Soins traitements'
                  ]
               ]

            ]
         ]
      ];
   }
   public function getCategoryAccessoires()
   {
      return  [
         "accessoires-des-cheveux" =>
         [
            "category" => "Accessoires des cheveux",
            'sous_category' => [
               'accessoires-des-cheveux' => [
                  'name' => 'Accessoires des cheveux',
                  'options' => [
                     'Noeud', 'Serre t??te ', 'Pince ?? cheveux', 'Brousse', 'Elastique de cheveux', 'Barettes', 'Bandeau'
                  ]
               ]

            ]
         ],
         "bijoux-et-montres" =>
         [
            "category" => "Bijoux et montres",
            'sous_category' => [
               'bijoux-et-montres' => [

                  'name' => 'Bijoux et montres',
                  'options' => [
                     'Boucle d???oreilles', 'Colliers', 'Pendentif', 'Gourmette', 'Alliances', 'Boutons de manchette', 'Bracelets', 'Bague', 'Parure de bague', 'Chaine', 'Sautoir', 'Montres'
                  ]
               ]

            ]
         ],
         "sacs-et-maroquineries" =>
         [
            "category" => "Sacs et maroquineries",
            'sous_category' => [
               'sacs-et-maroquineries' => [

                  'name' => 'Sacs et maroquineries',
                  'options' => [
                     'Sac ?? main', 'Sac ?? dos', 'Sac de voyage', 'Sac bandouli??re ', 'Portefeuilles et porte-cartes', 'Cabas', 'Pochettes', 'Sacs bowling', 'Sacs port??s ??paule '
                  ]
               ]

            ]
         ],
         "fashion-plus" =>
         [
            "category" => "Fashion plus",
            'sous_category' => [
               'fashion-plus' => [

                  'name' => 'Fashion plus',
                  'options' => [
                     'Ceinture', 'Gants', 'Casquettes', 'Chapeaux', 'Echarpes', 'Foulards', 'Bonnets', 'Headband', 'Cravates ', 'Lunettes'
                  ]
               ]

            ]
         ]
      ];
   }
   public function getCategoryServices()
   {
      return  [
         "marketing" =>
         [
            "category" => "Marketing",
            'sous_category' => [
               'visuel' => [

                  'name' => 'Visuel',
                  'options' => [
                     "Communication", "Promotion", "Publicit??", "Contenus", "Vogue"
                  ]
               ]

            ]
         ],
         "emplois" =>
         [
            "category" => "Emplois",
            'sous_category' => [
               "emplois" => [
                  'name' => 'Emplois',
                  'options' => [
                     "Offres d'emplois",
                     "Demande d'emplois",
                     "Profils"
                  ]
               ]
            ]
         ],
         "formations" => [
            "category" => "Formations",

            'sous_category' => [
               "formation-en-ligne" => [
                  'name' => 'Formation en ligne',
                  'options' => [
                     "BTP","Digitalisation","D??veloppement","Comptabilit??","Resource humaine","G??n??rale"
                  ]
               ]

            ]
         ],
         "educations" => [
            "category" => "Educations",

            'sous_category' => [
               "etablissement" => [

                  'name' => 'Etablissement',
                  'options' => [
                     "G??n??ral", "Technique", "Sp??cialis??", "Etablissement public", "Astuce pedagogie"
                  ]
               ]
            ]
         ],
         "sante-hygiene" => [
            "category" => "Sant??-hygi??ne",
            'sous_category' => [
               "sante-hygiene" => [
                  'name' => 'Sant??/Hygi??ne',
                  'options' => [
                     "Astuce", "Tra??tement", "Conseil", "Cabinet m??dical", "Pharmacie", "Homeopharma"
                  ]
               ]

            ]
         ]
      ];
   }
   public function getCategoryMode()
   {
      return [
         "habillement-homme" =>
         [
            "category" => "Habillement homme",
            'sous_category' => [

               "vetement-homme" => [
                  'name' => 'V??tement homme',
                  'options' => [
                     'Chemise', 'Jeans', 'T-shirts', 'Polos', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Costumes', 'Vestes', 'Pantalons', 'Short', 'Bermudas', 'Tenues de Sports', 'Vetement de nuit', 'Impermeable', 'Maillots de Bains', 'Chaussettes', 'Ensemble', 'Jogging', 'Blousons'
                  ]
               ],
               "chaussure-homme" => [
                  'name' => 'Chaussure homme',
                  'options' => [
                     'Derbies', 'Chaussures de ville', 'Slippers', 'Derbie', 'Baskets', 'Bottes', 'Boots', 'Chaussons', 'Chaussures bateau', 'Chaussures de Securit??', 'Chaussures de sports', 'Espadrilles', 'Mocassins', 'Mulle', ' Sabot', 'Sandales', 'Tongs'
                  ]
               ],
               "lingeries-homme" => [
                  'name' => 'Lingeries homme',
                  'options' => [
                     'Cale??on', 'Boxeur', 'Slips', 'Short', 'Jock strap', 'Chaussette', 'Pantie'
                  ]
               ]

            ]
         ],
         "habillement-femme" =>
         [
            "category" => "Habillement femme",
            'sous_category' => [
               "vetement-femme" => [
                  'name' => 'V??tement femme',
                  'options' => [
                     'Robe de ceremonie', 'Robe de mari??e', 'Robe de fian??aille', 'Sweats-Shirts', 'Jeans', 'Cardigans', 'Chemise', 'Body', 'Blouse', 'T-shirts', 'Polos', 'D??bardeur', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Tailleurs', 'Vestes', 'Blousons', 'Jupes', 'Pantalons', 'Salopettes', 'Combinaisons', 'Combi-short', 'Chaussettes', 'Collants', 'V??tements de Grossesse', 'Vetement de nuit', 'Vetement de Sports', 'Imperm??able', 'Maillots de Bains', 'Costumes', 'Ensemble', 'Jogging'
                  ]
               ],
               "chaussure-femme" => [
                  'name' => 'Chaussure femme',
                  'options' => [
                     'Ballerines ', 'Baskets', 'Bottes', 'Boots', 'Chaussons', 'Chaussures Bateau', 'Chaussures de Securit??', 'Chaussures de ville', 'Derbie', 'Designer', 'Escarpins', 'Espadrilles', ' Mary Janes', 'Mocassins', 'Mulle', 'Sabot', 'Sandales', 'Sport', 'Tongs'
                  ]
               ],
               "lingeries-femme" => [
                  'name' => 'Lingeries femme',
                  'options' => [
                     'Slips', 'Dentelle c??t??', 'Tanga', 'Boxer', 'Accessoires', 'Bas', 'Jarreti??res', 'Bodys', 'Bustiers', 'corsets', 'Caracos', 'Combinaisons', 'Jupons', 'Culottes', 'Shorties', 'Strings', 'Ensembles de Lingeries', 'Lingeries Sculptantes', 'Nuisettes', 'Deshabill??s', 'V??tements Th??rmiques', 'Soutiens Gorges'
                  ]
               ],
            ]
         ],
         "habillement-enfant" => [
            "category" => "Habillement enfant",

            'sous_category' => [
               "vetement-enfant" => [
                  'name' => 'V??tement enfant',
                  'options' => [
                     'Pantalon', 'Cardigans', ' Blousons', 'Sweats-Shirts', 'Bermudas', 'Chemise', 'T-shirts', 'Polos', 'Pulls', 'Jean', 'Short', 'Bermudas', 'Salopettes', 'Ensembles', 'Maillots de bains', 'Sous - v??tements', 'Joggins', 'Imperm??able'
                  ]
               ],
               "lingeries-enfant" => [
                  'name' => 'Lingeries enfant',
                  'options' => [
                     'Salopette', 'Jeans', 'Sweat-Shirt', 'Tailleur', 'Veste', 'Chemise', 'Blouses', 'T-shirts', 'Pulls', 'D??bardeur', 'Gilets', 'Cardigans', 'Manteaux', 'Blousons', 'Jupes', 'Short', 'Bermudas', 'Pantalons', 'Leggins', 'Robes', 'Ensembles', 'Salopettes', 'Combinaisons', 'Combi-short', 'Sous - v??tements', 'Collants', 'Maillots de Bains', 'Tenues de Sports', 'V??tements de nuits', 'Peignoirs', 'Imperm??able'
                  ]
               ],
               "chaussure-enfant" => [
                  'name' => 'Chaussure enfant',
                  'options' => [
                     'Escarpins', 'Boots', ' Babies', 'Ballerines', 'Baskets mode', 'Bottes', 'Bottines', 'Chaussures Bateau', 'Chaussures de Sport', 'Chaussures de ville', 'Espadrilles', 'Mocassins', 'Mulle', 'Sabot', 'Sandales', 'Tongs '
                  ]
               ]

            ]
         ],
         "habillement-bebe" => [
            "category" => "Habillement b??b??",
            'sous_category' => [
               "bebe-garcons" => [
                  'name' => 'B??b?? gar??on',
                  'options' => [
                     'Couverture B??b??', 'Peluches', 'Veste', 'Salopettes', 'Combinaison', 'Sweat-Shirt', 'Polos', 'Bodys', 'Grenoulli??re', 'T-shirts', 'D??bardeur', 'Chemise', 'Pulls', 'Cardigans', 'Pantalons', 'Shor', 'Pyjamas', 'Ensembles', 'Chaussettes', 'Maillots de bains'
                  ]
               ],
               "bebe-fille" => [
                  'name' => 'B??b?? fille',
                  'options' => [
                     'Couverture B??b??', 'Peluches', 'Vestes', 'Salopette', 'Combinaisons', 'Sweats-Shirts', 'Polos', 'Bodys', 'Grenoull??re', 'T-shirts', 'D??bardeur', 'Chemise  ', 'Pulls', 'Cardigans', 'Pantalons', 'Short', 'Pyjamas', 'Ensembles', 'Robes', 'Chaussettes', 'Maillots de bains'
                  ]
               ],
               "bebe-chaussure" => [
                  'name' => 'B??b?? chaussure',
                  'options' => [
                     'Baskets', 'Babies', 'Bottes', 'Botillons', 'Boots', 'Chaussons', 'Sandales'
                  ]
               ]
            ]
         ]
         ,
         "accessoires-des-cheveux" =>
         [
            "category" => "Accessoires des cheveux",
            'sous_category' => [
               'accessoires-des-cheveux' => [
                  'name' => 'Accessoires des cheveux',
                  'options' => [
                     'Noeud', 'Serre t??te ', 'Pince ?? cheveux', 'Brousse', 'Elastique de cheveux', 'Barettes', 'Bandeau'
                     
                  ]
               ]

            ]
         ],
         "bijoux-et-montres" =>
         [
            "category" => "Bijoux et montres",
            'sous_category' => [
               'bijoux-et-montres' => [

                  'name' => 'Bijoux et montres',
                  'options' => [
                     'Boucle d???oreilles', 'Colliers', 'Pendentif', 'Gourmette', 'Alliances', 'Boutons de manchette', 'Bracelets', 'Bague', 'Parure de bague', 'Chaine', 'Sautoir', 'Montres'
                  ]
               ]

            ]
         ],
         "sacs-et-maroquineries" =>
         [
            "category" => "Sacs et maroquineries",
            'sous_category' => [
               'sacs-et-maroquineries' => [

                  'name' => 'Sacs et maroquineries',
                  'options' => [
                     'Sac ?? main', 'Sac ?? dos', 'Sac de voyage', 'Sac bandouli??re ', 'Portefeuilles et porte-cartes', 'Cabas', 'Pochettes', 'Sacs bowling', 'Sacs port??s ??paule '
                  ]
               ]

            ]
         ],
         "fashion-plus" =>
         [
            "category" => "Fashion plus",
            'sous_category' => [
               'fashion-plus' => [

                  'name' => 'Fashion plus',
                  'options' => [
                     'Ceinture', 'Gants', 'Casquettes', 'Chapeaux', 'Echarpes', 'Foulards', 'Bonnets', 'Headband', 'Cravates ', 'Lunettes'
                  ]
               ]

            ]
                  ],
                  "parfumeries" =>
                  [
                     "category" => "Parfumeries",
                     'sous_category' => [
                        'parfumeries' => [
         
                           'name' => 'Parfumeries',
                           'options' => [
                              'Eaux de toilettes', 'D??odorants homme', 'D??odorants femme', 'Parfums homme', 'Parfum femme', 'Eaux de Cologne'
                           ]
                        ]
         
                     ]
                  ],
                  "beaute-bio" =>
                  [
                     "category" => "Beaut?? bio",
                     'sous_category' => [
                        'beaute-bio' => [
         
                           'name' => 'Beaut?? bio',
                           'options' => [
                              'Huile essentielle', 'Huile v??g??tale', 'Huile massage', 'Produits naturels amincissant'
                           ]
                        ]
         
                     ]
                  ],
                  "cosmetiques" =>
                  [
                     "category" => "Cosm??tiques",
                     'sous_category' => [
                        'soins-de-corps-et-visage' => [
                           'name' => 'Soins de corps et visage',
                           'options' => [
                              'Crayons et eyeliners', 'Mascaras', 'Ombres ?? paupi??res', 'Palettes et coffrets', 'Blush et poudres', 'Fonds de teint et BB cr??me', 'Rouges ?? l??vres', 'Primers et correcteurs', 'pilateurs sourcils', 'D??pilatoires', 'Accessoires maquillage ', 'Anti-rides et anti-??ges', 'Masques et gommages', 'Nettoyants et d??maquillants', 'Purifiants et matifiants', 'Soins des l??vres et des yeux', 'Cr??mes', 'Cr??me solaire', 'Lotions', 'Baume', 'Emulsions', 'Huiles pour la peau', 'produits de bronzage', 'produits pour le rasage', 'Produits d???hygi??ne dentaire et buccale', 'Produits d???hygi??ne  intime externe', 'Bain & douche', 'Savons de toilette', 'Soins hydratants et nourrissants'
                           ]
                        ],
                        'soins-des-ongles' => [
         
                           'name' => 'Soins des ongles',
                           'options' => [
                              'Base protectrice Clean', 'Vernis', 'Dissolvant', 'Faux ongles', 'Lime'
                           ]
                        ],
                        'soins-des-cheveux' => [
         
                           'name' => 'Soins des cheveux',
                           'options' => [
                              'Pack de produits', 'Vaporisateurs', 'Fixateurs', 'Shampooings', 'Apr??s-shampooings', 'Masques', 'Gel', 'Colorants', 'Produit pour l\'ondulation', 'Produit de coiffage', 'Huiles', 'Soins traitements'
                           ]
                        ]
         
                     ]
                  ]
         
      ];
   }
   public function getCategoryHabillement()
   {
      return  [
         "habillement-homme" =>
         [
            "category" => "Habillement homme",
            'sous_category' => [

               "vetement-homme" => [
                  'name' => 'V??tement homme',
                  'options' => [
                     'Chemise', 'Jeans', 'T-shirts', 'Polos', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Costumes', 'Vestes', 'Pantalons', 'Short', 'Bermudas', 'Tenues de Sports', 'Vetement de nuit', 'Impermeable', 'Maillots de Bains', 'Chaussettes', 'Ensemble', 'Jogging', 'Blousons'
                  ]
               ],
               "chaussure-homme" => [
                  'name' => 'Chaussure homme',
                  'options' => [
                     'Derbies', 'Chaussures de ville', 'Slippers', 'Derbie', 'Baskets', 'Bottes', 'Boots', 'Chaussons', 'Chaussures bateau', 'Chaussures de Securit??', 'Chaussures de sports', 'Espadrilles', 'Mocassins', 'Mulle', ' Sabot', 'Sandales', 'Tongs'
                  ]
               ],
               "lingeries-homme" => [
                  'name' => 'Lingeries homme',
                  'options' => [
                     'Cale??on', 'Boxeur', 'Slips', 'Short', 'Jock strap', 'Chaussette', 'Pantie'
                  ]
               ]

            ]
         ],
         "habillement-femme" =>
         [
            "category" => "Habillement femme",
            'sous_category' => [
               "vetement-femme" => [
                  'name' => 'V??tement femme',
                  'options' => [
                     'Robe de ceremonie', 'Robe de mari??e', 'Robe de fian??aille', 'Sweats-Shirts', 'Jeans', 'Cardigans', 'Chemise', 'Body', 'Blouse', 'T-shirts', 'Polos', 'D??bardeur', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Tailleurs', 'Vestes', 'Blousons', 'Jupes', 'Pantalons', 'Salopettes', 'Combinaisons', 'Combi-short', 'Chaussettes', 'Collants', 'V??tements de Grossesse', 'Vetement de nuit', 'Vetement de Sports', 'Imperm??able', 'Maillots de Bains', 'Costumes', 'Ensemble', 'Jogging'
                  ]
               ],
               "chaussure-femme" => [
                  'name' => 'Chaussure femme',
                  'options' => [
                     'Ballerines ', 'Baskets', 'Bottes', 'Boots', 'Chaussons', 'Chaussures Bateau', 'Chaussures de Securit??', 'Chaussures de ville', 'Derbie', 'Designer', 'Escarpins', 'Espadrilles', ' Mary Janes', 'Mocassins', 'Mulle', 'Sabot', 'Sandales', 'Sport', 'Tongs'
                  ]
               ],
               "lingeries-femme" => [
                  'name' => 'Lingeries femme',
                  'options' => [
                     'Slips', 'Dentelle c??t??', 'Tanga', 'Boxer', 'Accessoires', 'Bas', 'Jarreti??res', 'Bodys', 'Bustiers', 'corsets', 'Caracos', 'Combinaisons', 'Jupons', 'Culottes', 'Shorties', 'Strings', 'Ensembles de Lingeries', 'Lingeries Sculptantes', 'Nuisettes', 'Deshabill??s', 'V??tements Th??rmiques', 'Soutiens Gorges'
                  ]
               ],
            ]
         ],
         "habillement-enfant" => [
            "category" => "Habillement enfant",

            'sous_category' => [
               "vetement-enfant" => [
                  'name' => 'V??tement enfant',
                  'options' => [
                     'Pantalon', 'Cardigans', ' Blousons', 'Sweats-Shirts', 'Bermudas', 'Chemise', 'T-shirts', 'Polos', 'Pulls', 'Jean', 'Short', 'Bermudas', 'Salopettes', 'Ensembles', 'Maillots de bains', 'Sous - v??tements', 'Joggins', 'Imperm??able'
                  ]
               ],
               "lingeries-enfant" => [
                  'name' => 'Lingeries enfant',
                  'options' => [
                     'Salopette', 'Jeans', 'Sweat-Shirt', 'Tailleur', 'Veste', 'Chemise', 'Blouses', 'T-shirts', 'Pulls', 'D??bardeur', 'Gilets', 'Cardigans', 'Manteaux', 'Blousons', 'Jupes', 'Short', 'Bermudas', 'Pantalons', 'Leggins', 'Robes', 'Ensembles', 'Salopettes', 'Combinaisons', 'Combi-short', 'Sous - v??tements', 'Collants', 'Maillots de Bains', 'Tenues de Sports', 'V??tements de nuits', 'Peignoirs', 'Imperm??able'
                  ]
               ],
               "chaussure-enfant" => [
                  'name' => 'Chaussure enfant',
                  'options' => [
                     'Escarpins', 'Boots', ' Babies', 'Ballerines', 'Baskets mode', 'Bottes', 'Bottines', 'Chaussures Bateau', 'Chaussures de Sport', 'Chaussures de ville', 'Espadrilles', 'Mocassins', 'Mulle', 'Sabot', 'Sandales', 'Tongs '
                  ]
               ]

            ]
         ],
         "habillement-bebe" => [
            "category" => "Habillement b??b??",
            'sous_category' => [
               "bebe-garcons" => [
                  'name' => 'B??b?? gar??on',
                  'options' => [
                     'Couverture B??b??', 'Peluches', 'Veste', 'Salopettes', 'Combinaison', 'Sweat-Shirt', 'Polos', 'Bodys', 'Grenoulli??re', 'T-shirts', 'D??bardeur', 'Chemise', 'Pulls', 'Cardigans', 'Pantalons', 'Shor', 'Pyjamas', 'Ensembles', 'Chaussettes', 'Maillots de bains'
                  ]
               ],
               "bebe-fille" => [
                  'name' => 'B??b?? fille',
                  'options' => [
                     'Couverture B??b??', 'Peluches', 'Vestes', 'Salopette', 'Combinaisons', 'Sweats-Shirts', 'Polos', 'Bodys', 'Grenoull??re', 'T-shirts', 'D??bardeur', 'Chemise  ', 'Pulls', 'Cardigans', 'Pantalons', 'Short', 'Pyjamas', 'Ensembles', 'Robes', 'Chaussettes', 'Maillots de bains'
                  ]
               ],
               "bebe-chaussure" => [
                  'name' => 'B??b?? chaussure',
                  'options' => [
                     'Baskets', 'Babies', 'Bottes', 'Botillons', 'Boots', 'Chaussons', 'Sandales'
                  ]
               ]
            ]
         ]
      ];
   }

   public function getCategoryBlog(){
       return [
               "blog" => [
                   "category"=>"blog",
                        "sous_category"=>[
                           "blog"=>[
                              "name"=>"Blog",
                              "options"=>[
                                    'Actualit??s','Atouts','Astuces','Test','Tutoriels'
                              ]
                           ]
                   ]
               ]
       ];
   }
   public function  getCategoryHighTech()
   {
      return  [
         "informatique" =>
         [
            "category" => "Informatique",
            'sous_category' => [
               "materiels-informatique" => [

                  'name' => 'Mat??riels informatique',
                  'options' => [
                     'Ordinateurs de bureau', 'ordinateurs portables', 'Tablette', 'Univers gaming', 'Composants - p??rif??rique', 'Stockage', 'R??seaux'
                  ]

               ],
               "diagnostiques" => [

                  'name' => 'Diagnostiques',
                  'options' => [
                     'Hardware', 'Software'
                  ]
               ]
            ]
         ],
         "systeme-domotique" =>
         [
            "category" => "Syst??me domotique",
            'sous_category' => [
               "systeme-domotique" => [

                  'name' => "Syst??me domotique",
                  'options' => [
                     'Motorisation', 'portails et volets', 'Accessoires', 'Interphone video', 'Alarme-D??tecteur', 'Cam??ra de surveillance', 'S??curit??  incendie'
                  ]
               ]
            ]
         ],
         "impression" =>
         [
            "category" => "Impression",
            'sous_category' => [
               "impression" => [
                  'name' => "Impression",
                  'options' => [
                     'Imprimante jet d\'encre', 'Imprimante laser', 'Scaner', 'Cartouches', 'Toners'
                  ]
               ]
            ]
         ],
         "images-et-son" =>
         [
            "category" => "Images et son",
            'sous_category' => [
               "tv" => [
                  'name' => 'Tv',
                  'options' => [
                     'TV LED-LCD', 'TV 4K-UHD', 'Support TV', 'TV connect??e', 'Smart TV'
                  ]
               ],
               "video-projecteur" => [
                  'name' => 'Video projecteur',
                  'options' => [
                     'HD Ready', 'Full HD', '4K/UHD', 'Accessoires'
                  ]
               ],
               "son" => [
                  'name' => 'Son',
                  'options' => [
                     'Casque auto', 'Enceintes bleutooth', 'MP3', 'MP4', 'Radio', 'Dictaphone', 'Hifi', 'Bare de son'
                  ]
               ],
               "photos-et-camera" => [
                  'name' => 'Photos et cam??ra',
                  'options' => [
                     'Flash photo', 'Filtre', 'Cam??scope cam??ra', 'Objectif reflex', 'Objectif cam??ra', 'GoPro', 'Autre'
                  ]
               ],
               "tous-les-accessoires" => [
                  'name' => 'Tous les accessoires',
                  'options' => [
                     'C??ble et connectique', 'Accessoires audio et video', 'Accessoires photos', 'Accessoires cam??ra'
                  ]
               ]
            ]
         ]
      ];
   }
}
