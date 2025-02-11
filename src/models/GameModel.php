<?php
class GameModel
{
    private $client;
    private $top_100_actors;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->top_100_actors = [
            "Robert De Niro",
            "Al Pacino",
            "Jack Nicholson",
            "Meryl Streep",
            "Harrison Ford",
            "Dustin Hoffman",
            "Clint Eastwood",
            "Sigourney Weaver",
            "Jeff Bridges",
            "Diane Keaton",
            "Tom Hanks",
            "Denzel Washington",
            "Johnny Depp",
            "Anthony Hopkins",
            "Robin Williams",
            "Bruce Willis",
            "Michelle Pfeiffer",
            "Kevin Costner",
            "Mel Gibson",
            "Jodie Foster",
            "Leonardo DiCaprio",
            "Brad Pitt",
            "Edward Norton",
            "Cate Blanchett",
            "Kate Winslet",
            "Russell Crowe",
            "Samuel L. Jackson",
            "Nicole Kidman",
            "Keanu Reeves",
            "Joaquin Phoenix",
            "Christian Bale",
            "Hugh Jackman",
            "Natalie Portman",
            "Scarlett Johansson",
            "Charlize Theron",
            "Matt Damon",
            "Amy Adams",
            "Javier Bardem",
            "Mark Ruffalo",
            "Daniel Craig",
            "Ryan Gosling",
            "Margot Robbie",
            "Florence Pugh",
            "Timothée Chalamet",
            "Adam Driver",
            "Zendaya",
            "Tom Hardy",
            "Jessica Chastain",
            "Chris Hemsworth",
            "Emily Blunt",
            "Willem Dafoe",
            "Frances McDormand",
            "Viola Davis",
            "Michael Fassbender",
            "Tilda Swinton",
            "Jake Gyllenhaal",
            "Cillian Murphy",
            "Oscar Isaac",
            "Robert Pattinson",
            "Anya Taylor-Joy",
            "Jim Carrey",
            "Will Smith",
            "Bill Murray",
            "Steve Carell",
            "Ben Stiller",
            "Chris Evans",
            "Gal Gadot",
            "Paul Rudd",
            "Jason Momoa",
            "Ryan Reynolds",
            "Austin Butler",
            "Florence Pugh",
            "Jenna Ortega",
            "Barry Keoghan",
            "Tom Holland",
            "Hailee Steinfeld",
            "Sydney Sweeney",
            "Jonathan Majors",
            "Maya Hawke",
            "Simu Liu",
            "Christoph Waltz",
            "Mahershala Ali",
            "Benedict Cumberbatch",
            "Andrew Garfield",
            "Lakeith Stanfield",
            "Pedro Pascal",
            "Idris Elba",
            "Riz Ahmed",
            "Ewan McGregor",
            "Jared Leto",
            "Javier Bardem",
            "Penélope Cruz",
            "Marion Cotillard",
            "Daniel Day-Lewis",
            "Rami Malek",
            "Lupita Nyong’o",
            "Dev Patel",
            "Michelle Yeoh",
            "Ken Watanabe",
            "Song Kang-ho"
        ];
    }

    public function getRandomActors()
    {
        $randomKeys = array_rand($this->top_100_actors, 2);
        return [$this->top_100_actors[$randomKeys[0]], $this->top_100_actors[$randomKeys[1]]];
    }

    public function initializeGame()
    {
        if (!isset($_SESSION['actor1']) || !isset($_SESSION['actor2'])) {
            list($actor1, $actor2) = $this->getRandomActors();
            $_SESSION['actor1'] = $actor1;
            $_SESSION['actor2'] = $actor2;
            $_SESSION['path'] = [$actor1];
        }
    }

    public function resetGame()
    {
        unset($_SESSION['path'], $_SESSION['actorSearch'], $_SESSION['movieSearch']);
    }

    public function refreshGame()
    {
        unset($_SESSION['path'], $_SESSION['actorSearch'], $_SESSION['movieSearch'], $_SESSION['actor1'], $_SESSION['actor2']);
    }

    public function searchMovie($movie)
    {
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/search/movie?query={$movie}&language=en-US", [
            'headers' => ['Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5OWQ0ZmYxYmYyZWRhZDhmNzFlMDA0YjY4ZDc1YWMxOSIsIm5iZiI6MTczNzQ2NzEzOC45MDQsInN1YiI6IjY3OGZhNTAyOGEyMGNlZWViN2FhYjc1ZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.IF7yIkNO2IF9mh7IDuc1d67bhZCbSFRg4Dx4PTADyzI', 'accept' => 'application/json'],
            'verify' => false
        ]);

        return json_decode($response->getBody(), true)['results'] ?? [];
    }

    public function getMovieCast($movieId)
    {
        $response = $this->client->request('GET', "https://api.themoviedb.org/3/movie/{$movieId}/credits?language=fr-FR", [
            'headers' => ['Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI5OWQ0ZmYxYmYyZWRhZDhmNzFlMDA0YjY4ZDc1YWMxOSIsIm5iZiI6MTczNzQ2NzEzOC45MDQsInN1YiI6IjY3OGZhNTAyOGEyMGNlZWViN2FhYjc1ZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.IF7yIkNO2IF9mh7IDuc1d67bhZCbSFRg4Dx4PTADyzI', 'accept' => 'application/json'],
            'verify' => false
        ]);

        return json_decode($response->getBody(), true)['cast'] ?? [];
    }

    public function validateActorConnection($actor1, $actor3, $movie)
    {
        $movies = $this->searchMovie($movie);
        if (empty($movies))
            return ['error' => "Aucun film trouvé"];

        $movieId = $movies[0]['id'];
        $cast = $this->getMovieCast($movieId);

        $foundActor1 = array_filter($cast, fn($actor) => $actor['name'] === $actor1);
        $foundActor3 = array_filter($cast, fn($actor) => $actor['name'] === $actor3);

        if (!empty($foundActor1) && !empty($foundActor3)) {
            $_SESSION['path'][] = $movie;
            $_SESSION['path'][] = $actor3;
            return ['success' => "Les acteurs {$actor1} et {$actor3} sont dans le film {$movie}"];
        }

        if (empty($foundActor1))
            return ['warning' => "{$actor1} n'est pas dans le film {$movie}"];
        if (empty($foundActor3))
            return ['warning' => "{$actor3} n'est pas dans le film {$movie}"];
    }
}
