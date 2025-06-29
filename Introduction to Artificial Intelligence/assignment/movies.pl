% Movie database: movie(Title, Genre, Rating, Year)
movie('The Shawshank Redemption', drama, 9.3, 1994).
movie('The Godfather', crime, 9.2, 1972).
movie('The Dark Knight', action, 9.0, 2008).
movie('Pulp Fiction', crime, 8.9, 1994).
movie("Schindler's List", history, 9.0, 1993).
movie('The Lord of the Rings: The Return of the King', fantasy, 8.9, 2003).
movie('Inception', sci_fi, 8.8, 2010).
movie('Forrest Gump', drama, 8.8, 1994).
movie('Gladiator', action, 8.5, 2000).
movie('The Matrix', sci_fi, 8.7, 1999).

% User preferences || facts about users
likes_genre(abel, drama).
likes_genre(abel, sci_fi).
likes_genre(mary, action).
likes_genre(mary, crime).

likes_high_rating(abel, 8.7).
likes_high_rating(mary, 8.5).

likes_release_year(abel, 1995).
likes_release_year(mary, 1990).

% Recommend movies based on genre preference
recommend_by_genre(User, Movie) :-
    likes_genre(User, Genre),
    movie(Movie, Genre, _, _).

% Recommend movies based on rating preference
recommend_by_rating(User, Movie) :-
    likes_high_rating(User, MinRating),
    movie(Movie, _, Rating, _),
    Rating >= MinRating.

% Recommend movies based on release year preference
recommend_by_year(User, Movie) :-
    likes_release_year(User, MinYear),
    movie(Movie, _, _, Year),
    Year >= MinYear.

% Combined recommendation rule
recommend_movie(User, Movie) :-
    recommend_by_genre(User, Movie),
    recommend_by_rating(User, Movie),
    recommend_by_year(User, Movie).
