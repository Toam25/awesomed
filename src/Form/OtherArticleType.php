<?php

namespace App\Form;

use App\Entity\Article;
use App\Service\CategoryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OtherArticleType extends AbstractType
{    
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService= $categoryService;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Titre',
                'attr'=>[
                    'class'=>'form-control'
                ]

            ])
            ->add('price',NumberType::class,[
                'label'=>'Prix',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('price_promo',NumberType::class,[
                'label'=> 'Prix promo',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('price_global',NumberType::class,[
                'label'=>'Prix en gros',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('quantity',TextType::class,[
                'label'=>'Stock',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])

            ->add('sous_category',HiddenType::class)
            ->add('promo',ChoiceType::class,[
                'label'=>'Promotion',
                'attr'=>[
                    'class'=>'form-control'
                ],
                'choices'=>[
                    'Normal'=>'Normal',
                    'Promotion'=>'Promotion',
                    'new'=>'New',
                    'vendu'=>'Vendu'
                ]
            ])
            ->add('marque',TextType::class,[
                'label'=>'Marque',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('category',HiddenType::class)
            ->add('type', ChoiceType::class, [
                'label'=>'type',
                'choices' => $this->getTypeArticle(),
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('wordKey',TextType::class,[
                'label'=>'Mots cl??s',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label'=>'D??scription',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('images',FileType::class,[
                'attr'=>[
                    'class'=>'form-control file'
                ],
                'label'=>"images",
                'multiple'=>true,
                'mapped'=>false,
                'required'=> false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    private  $type = [
        'Chemise', 'Barettes','Bandeau','Jeans', 'T-shirts', 'Polos', 'Pulls', 'Gilets', 'Sweats-Shirts', 'Manteaux', 'Costumes', 'Vestes', 'Pantalons', 'Short', 'Bermudas', 'Tenues de Sports', 'Vetement de nuit', 'Impermeable', 'Maillots de Bains', 'Chaussettes', 'Ensemble', 'Jogging', 'Blousons', 'Derbies', 'Chaussures de ville', 'Slippers', 'Derbie', 'Basket', 'Bottes', 'Boots', 'Chaussons', 'Chaussures bateau', 'Chaussures de Securit??', 'Chaussures de sports', 'Espadrilles', 'Mocassins', 'Mulle', 'Sabot', ' Sandales', 'Tongs', 'Cale??o', 'Boxeur', 'Slips', 'Shorty', 'Jock strap', 'Chaussette', 'Pantie', 'Robe de ceremonie', 'Robe de mari??e', 'Robe de fian??aille', 'Cardigans', 'Body', 'Blouse', 'D??bardeur', 'Tailleurs ', 'Jupes', 'Salopettes', 'Short et Bermudas', 'Leggins', 'Robes', 'Combi-short', 'Collants', 'V??tements de Grossess', 'V??tement de nuit', 'V??tement de Sports', 'Imperm??able', 'Maillots de Bains', 'Ballerines', 'Baskets', 'Botte', 'Dentelle c??t??', 'Tanga', 'Boxer',  'Accessoires', 'Bas', 'Jarreti??res', 'Bodys', 'Bustiers', 'Corsets', 'Caracos', 'Combinaisons', 'Jupons', 'Culottes', 'Shorties', 'Strings', 'Ensembles de Lingeries', 'Lingeries', 'Nuisettes', 'Deshabill??s', 'V??tements Th??rmiques', 'Soutiens Gorges', 'Pantalon', 'Cardigans', 'Jean', 'Bermuda', 'Sous v??tements', 'Joggins', 'Salopette', 'Sweat-Shirt', 'Tailleur', 'Escarpins', 'Babies', 'Baskets mode', 'Couverture B??b??', 'Peluches', 'Veste', 'Salopettes', 'Combinaison', 'Sweat-Shirt', 'Grenoulli??re', 'Pyjamas', 'Couverture B??b??', 'Botillon', 'Sac ?? main', 'Sac ?? dos', 'Sac de voyage', 'Sac bandouli??re', 'Portefeuilles et porte-cartes', 'Cabas', 'Pochettes', 'Sacs portes ??paule', 'Alliances', 'Montre', 'Parure de bague', 'Boutons de manchette', 'Bagues', 'Pendentifs', 'Boucles d\'oreilles', 'Bracelet', 'Broches', 'Colliers', 'Sautoir', 'Parures de bijoux', 'Cha??ne', 'Citrine', 'Quartz', 'Jade', 'Rubis', 'Diamant', 'Em??raude', 'Vannerie', 'Poterie', 'Miniature', 'Fruits / corbeilles ?? pain', 'Sets de table en bambou', 'Bo??te ?? ??pices', 'Cadre photo', 'Support de pot de fleur', 'Pots de fleur', 'D??coration murale', 'Objet design fer forge', 'Embout', 'Montre mural en fer forg??', 'Bougeoir', 'Photophore', 'Applique & Luminaires', 'Cornes de z??bu', 'Literie', 'Penderie', 'Table', 'Porte cintre', 'Chaise', 'Table avec chaise', 'Range chaussures', 'Sacs', 'Panier', 'Chapeaux', 'Nappe', 'Smoc', 'Couvre lit', 'Richelieu', 'Crochet', 'Ch??le', 'Malabary', 'Lambamena', 'Sacs', 'Panier', 'Chapeaux', 'Noeud', 'Serre t??te', 'Pince ?? cheveux', 'Brousse', 'Elastique de cheveux', 'bandeau', 'Boucle d???oreilles', 'Colliers', 'Pendentif', 'Gourmettes', 'Alliances', 'Boutons de manchette', 'Bracelets', 'Bague', 'Parure de bague', 'Chaine', 'Sautoir', 'Montres', 'Sacs bowling', 'Ceinture', 'Gants', 'Casquettes', 'Echarpes', 'Foulards', 'Bonnets', 'Headband', 'Cravates', 'Lunettes', 'Petite Flowerbox', 'Moyenne Fowerbox', 'Grande Flowerbox', 'Flowerbox personnalis??e', 'Eaux de toilettes', 'D??odorants homme', 'D??odorants femme', 'Parfums homme', 'Parfum femme', 'Eaux de Cologne', 'Huile essentielle', 'Huile v??g??tale', 'Huile massage', 'Produits naturels amincissant', 'Crayons et eyeliners', 'Mascaras', 'Ombres ?? paupi??res', 'Palettes et coffrets', 'Blush et poudres', 'Fonds de teint et BB cr??me', 'Rouges ?? l??vres', 'Primers et correcteurs', 'pilateurs sourcils', 'D??pilatoires', 'Accessoires maquillage', 'Anti-rides et anti-??ges', 'Masques et gommages', 'Nettoyants et d??maquillants', 'Purifiants et matifiants', 'Soins des l??vres et des yeux', 'Cr??mes', 'Lotions', 'Baume', 'Emulsions', 'Huiles pour la peau', 'Produits de bronzage', 'produits pour le rasage', 'Produits d\???hygi??ne dentaire et buccale', 'Produits d???hygi??ne  intime externe', 'Bain & douche', 'Savons de toilette', 'Soins hydratants et nourrissants', 'Base protectrice Clean', 'Vernis', 'DDissolvant', 'Faux ongles', 'Lime', 'Pack de produits', 'Vaporisateurs', 'Fixateurs', 'Shampooings', 'Apr??s-shampooings', 'Masques', 'Gel', 'Colorants', 'Produit pour l\'ondulation', 'Produit de coiffage', 'Huiles', 'Soins traitements', 'Coques', 'Batteries, Batteries externes', 'Ecouteurs bleutooth', 'Enceintes bleutooth', 'Chargeurs', 'Oreillette bleutooth', 'Kits mains libres', 'Protection ecran', 'Carte m??moire', 'T??l??phone fixe', 'T??l??phone avec touche', 'Smartphone', 'I-phone', 'TV LED-LCD', 'TV 4K-UHD', 'Support TV', 'TV connect??e', 'Smart TV', 'HD Ready', 'Full HD', '4K/UHD', 'Accessoires', 'Casque auto', 'Enceintes bleutooth, MP3, MP4', 'Radio', 'Dictaphone', 'Hifi', 'Bare de son', 'Flash photo', 'Filtre', 'Cam??scope cam??ra', 'Objectif reflex', 'Objectif cam??ra', 'GoPro', 'Autre', 'C??ble et connectique', 'Accessoires audio et video', 'Accessoires photos', 'Accessoires cam??ra', 'Ordinateurs de bureau', 'ordinateurs portables', 'Tablette', 'Univers gaming', 'Composants - p??rif??rique', 'Stockage', 'R??seaux', 'Hardware', 'Software', 'Imprimante jet d\'encre', 'Imprimante laser', 'Scaner', 'Cartouches', 'Toners', 'Motorisation', 'portails et volets', 'Accessoires', 'Interphone video', 'Alerme-D??tecteur', 'Cam??ra de surveillance', 'S??curit??  incendie', 'Comprime', 'Gellule', 'Liquide', 'Injectable', 'Visage', 'Corps', 'Cheveux', 'Autres', 'B??b??', 'Enfant', 'Femme enceinte', 'adulte', 'Rectale', 'Plantes m??dicinales', 'Produits de sant?? naturels', 'Compl??ment alimentaire', 'Argile verte', 'Huile d\'amande douce ', 'Huile d\'arachide', 'Femme enceinte', 'Huile d\'argan', 'Huile d\'avocat', 'Huile de baobab', 'Huile de calendula', 'Huile de cameline', 'Huile de coco', 'Huile de colza', 'Huile de germe de bl??', 'Beurre de Karit??', 'Huile de Moutarde', 'Huile d\'Olive', 'Huile de Palme', 'Huile de Ricin', 'Huile de Tournesol', 'Huile de S??same', 'Huile de Lorenzo', 'Huile de poisson'
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

   
}
