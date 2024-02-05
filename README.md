# Des réponses structurées et Twig

Niveau de difficulté : 3/5

Nous avons maintenant un framework capable de dispatcher les requêtes vers les bonnes actions ! 🥳

Il serait donc temps pour nous de faire autre chose qu'un `echo` dans celles-ci afin de pouvoir retourner des réponses structurées !

Tout ça sera bien entendu le rôle d'un nouveau service qu'on appellera `response` (ouais c'est dingue 🤯).

Dans un second temps, on va même offrir la possibilité à notre framework de pouvoir retourner des réponses avec des vues (du HTML donc) générées par le moteur de template Twig ! (ça sera un service également 🤯)

## Création du service `response`

Pour le service `response`, on n'aura même pas à surcharger la classe `Symfony\Component\HttpFoundation\Response` que met à notre disposition la dépendance `symfony/http-foundation`.

On va directement l'ajouter à notre Service Container depuis la méthode `boot()` de la classe `App`.

## Injection du service `response`

Les réponses doivent être retournées depuis les contrôleurs puisque ceux-ci feront le lien entre les modèles et les vues.

Notre instance de `App` étant un singleton, on pourrait y accéder aisément depuis nos contrôleurs.

Cepeeeendaaant (dernière fois après j'arrête), on va plutôt préférer passer nos services via les constructeurs de nos classes pour que celles-ci soient plus facilement testables (on l'a déjà fait en passant le service `request` au service `router`).

Sauf que là, mes services sont créés dans la classe `App` et que c'est ma classe `Router` qui vient instancier nos contrôleurs (dans la méthode `makeResponse()`).

Vous allez donc devoir :

1. Passer le service `response` au service `router`
2. Une fois rendu dans la classe `Router`, affecter l'instance de `Response` à une propriété `$response`
3. Utiliser ensuite la valeur de cette propriété pour transmettre le service `response` au constructeur du contrôleur instancié qui la stockera à son tour dans une propriété `$response` 🥵 (on fera ça depuis la classe `Controller` pour que toutes les classes enfants profitent de ce constructeur)

## Des actions qui retournent des réponses

Tout est en place pour gérer nos réponses depuis nos contrôleurs !

On va vouloir obliger nos actions à retourner une réponse de type `Symfony\Component\HttpFoundation\Response`.

On va donc commencer par indiquer que la méthode `makeResponse()` de `Router` doit retourner une instance de cette classe et faire donc le `return` approprié.

Même chose naturellement pour `dispatch()`.

Une fois que c'est fait, il va falloir indiquer à notre application qu'elle doit envoyer la réponse !

On va naturellement le faire depuis le front controller. Je vous laisse regarder [la documentation](https://symfony.com/doc/current/components/http_foundation.html#response) pour savoir comment envoyer la réponse à notre visiteur.

## Retournons des vraies réponses

Si vous actualisez votre site, vous devriez obtenir une erreur !

En effet, vous traitez maintenant votre application comme si ses actions retournaient forcément des réponses de la classe `Symfony\Component\HttpFoundation\Response`.

Sauf que pour l'instant, nos actions ne retournent rien du tout ! (elles font des `echo` plus que discutables)

Encore une fois, rendez-vous dans la documentation pour savoir comment indiquer le **contenu d'une réponse** (avec nos textes `Hello ..` pour l'instant).

A la fin de cette étape, tout devrait être rentré dans l'ordre et vos pages devraient de nouveau fonctionner !

La différence, c'est que nous pouvons maintenant gérer nos réponses avec une classe parfaitement adaptée.

## Place à Twig

Retourner des réponses c'est bien ! Retourner des réponses avec des vues générées par Twig, c'est mieux ! 🖼️

On va donc créer un service `twig` qu'on devra ajouter à notre service container (on commence à avoir l'habitude n'est-ce pas?).

Cette fois-ci, tout va se passer directement dans la fonction qu'on passera en 2ème argument à la méthode `singleton()` puisqu'on va simplement vouloir instancier les classes mises à disposition par Twig et configurer tout ça !

Pour savoir comment mettre en place Twig, rendez-vous dans [la documentation](https://twig.symfony.com/doc/3.x/api.html#basics) !

Trois indications pour vous aider à structurer tout ça :

1. La fonction devra retourner une instance de la classe `Twig\Environment`
2. Pas besoin de venir gérer la mise en cache des vues
3. Nos templates se trouveront tous dans le dossier `resources/views`

Une fois le service créé comme demandé, vous allez pouvoir lui faire suivre le même chemin que le service `response` en le transmettant au service `router` dans la méthode `boot()` puis en le transmettant au constructeur de notre contrôleur (vous le stockerez dans une propriété `$twig`).

Vous avez maintenant accès à votre service `twig` depuis votre contrôleur grâce à la propriété `$twig` !

On va pouvoir créer une méthode `view()` dans la classe `Controller` (qui pourra donc être utilisée dans toutes les classes enfants) dont le rôle sera de retourner une réponse avec la [vue générée à partir d'un template](https://twig.symfony.com/doc/3.x/api.html#rendering-templates) indiqué en paramètre.

La méthode view() aura 2 paramètres :

1. Une chaîne de caractère `$template` dont le rôle sera de contenir le template pour lequel on souhaite générer une vue
2. Un tableau `$data` qui sera optionnel et qui pourra contenir les données qu'on souhaite passer à nos templates

Testez tout ça en créant un template `resources/views/hello.html` qui va devoir être utilisé pour générer la réponse de l'action `hello()` et à qui on va donc devoir passer la propriété `$name` pour l'afficher sur notre belle page (Faites-moi rêver avec du beau CSS si vous voulez mais pas trop quand même 🥹).

Pour savoir comment utiliser Twig, ça se passe [juste ici](https://twig.symfony.com/doc/3.x/templates.html).

Fin de l'atelier ! 🥳
