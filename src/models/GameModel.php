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
            "Leonardo DiCaprio",
            "Brad Pitt",
            "Edward Norton",
            "Cate Blanchett",
            "Kate Winslet",
            "Russell Crowe",
            "Scarlett Johansson",
            "Charlize Theron",
            "Ryan Gosling",
            "Margot Robbie",
            "Timothée Chalamet",
            "Adam Driver",
            "Zendaya",
            "Tom Hardy",
            "Cillian Murphy",
            "Pedro Pascal"
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
