# Boxes of cubes

For a given box and a set of cubes (sides are powers of 2) the program finds the
smallest number of cubes needed to fill the box. An unsolvable problem yields `-1`.

## Requirements

- PHP 8.4+
- Composer

## Install

```bash
composer install
```

## Run

```bash
php bin/console boxes:calculate < problems.txt
```

(or `symfony console boxes:calculate < problems.txt` if you have the Symfony CLI)

### Input format

One problem per line:

```
width height depth qty0 qty1 qty2 ...
```

`qtyN` is the number of cubes with side `2^N` (1, 2, 4, 8, ...).

Example: `2 2 2 8 1` is a box 2×2×2 with 8 cubes 1×1×1 and 1 cube 2×2×2.

### Output

One number per line, the answer for the matching problem:

```
$ php bin/console boxes:calculate < problems.txt
1
8
1000
-1
9
62
59
50070
9
```

## Tests

```bash
php bin/phpunit
```

## Results on the provided test cases

All 9 sample problems from the task produce the expected output; none fail.
Every one of them is a case in the data provider of `tests/Domain/BoxServiceTest.php`.

### Approach

Greedy, largest cubes first. For each cube size `s` (from the biggest down):

1. Count how many cubes of side `s` fit in the box:
   `floor(width/s) * floor(height/s) * floor(depth/s)`.
2. Subtract the space already taken by bigger cubes (one cube of side `2s`
   takes the space of 8 cubes of side `s`).
3. Use as many cubes of side `s` as are available and still fit.

If the used cubes don't add up to the volume of the box, the problem is
unsolvable and the answer is `-1`.

This works because all sides are powers of two: the space left for smaller
cubes always splits exactly into them, so one big cube is never worse than
the several small ones it replaces.

### Where to look

- `src/Domain/BoxService.php`: the algorithm.
- `src/Domain/FilledBox.php`: state of the box while cubes are being added.
- `src/Command/BoxesCalculateCommand.php`: reads stdin, parses lines, prints answers.
