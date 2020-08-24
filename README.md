# BOMB DEFUSAL MANUAL GAME
Learnosity bootcamp demo project (#bootcamp2020)

![image](https://github.com/christian-crisologo-lrn/bomb-defusal-manual/blob/master/screenshot.jpg)


Inspired from the game [Bomb Manual](https://www.bombmanual.com/) using the Learnosity API.


#### Prerequisite
  Make sure you have `php` framework and library in your system

#### How to run the App
To run the app, follow the steps
1. Clone the repo
2. Go to `www` folder
3. Run the PHP server
```
  php -S localhost:8000
```

#### Game instruction
The game is playable with 2 players, 1 player is `Tech` and the other `Manual`.
- Tech - the bomb defuser who take instruction from the `Manual` and solve the puzzle to defuse the bomb. The `Tech` will get options with no questions so he has to rely with the `Manual` instructions.
- Manual - the person who will help the Tech to give the clues and help the solved the puzzles. The `Manual` has only the manual or set of instruction but has no idea what's the option so he has to help the `Tech` finding the best solution.

#### Playing with 2 Players
1. Choose `Tech` to be the bomb defuser
2. The other player should play `Manual`
3. In the 'level' selection, choose the game level. `Beginner` will allow multiple mistakes while the `Expert` will only allow 1 mistake.
4. Solve the puzzles every question. The `Manual` should find the best solution in the set of possible solution in the Manual.
5. Finish the game before the time runs out or the bomb explode

#### Player with 1 Player
1. Open 2 tabs for `Tech` and `Manual`
2. Play the `Tech` with the game level desire
3. In every question or puzzle, open the `Manual` to see the possible options
4. Go back to `Tech` to apply the answer

