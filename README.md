# Laravel travelling salesman problem algorithm

## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require ahmedtaha/travelling-salesman-path
```

## Usage

- The problem is to find the shorter route for desired locations. let’s consider some cities you’ve to visit. you should be visit all cities once with a least cost.

```php
       use Ahmedtaha\TravellingSalesman\Services\Concrete\TspBranchBound;

       $instance        = TspBranchBound::getInstance();
       
       #add starting point coordination
       $instance->addLocation([
        'id'            => 'Mansoura',
        'latitude'      => 31.0409,
        'longitude'     => 31.3785
      ]);
      
       #add array of another points coordination
      $instance->addLocation([
       [
            'id'        => 'Tanta',
            'latitude'  => 30.7865,
            'longitude' => 31.0004
        ],
        [
            'id'        => 'Ismailia',
            'latitude'  => 30.5965,
            'longitude' => 32.2715
        ],
        [
            'id'        => 'Damietta',
            'latitude'  => 31.4175,
            'longitude' => 31.8144
        ]
    ]);
    
     return $instance->solve();
```
## Result 


```json
{
  "cost": 495.6299999999999,
  "locations": [
    {
      "latitude" : 31.0409,
      "longitude": 31.3785,
      "id"       : "Mansoura"
    },
    {
      "latitude" : 31.4175,
      "longitude": 31.8144,
      "id"       : "Damietta"
    },
    {
      "latitude" : 30.7865,
      "longitude": 31.0004,
      "id"       : "Tanta"
    },
    {
      "latitude" : 30.5965,
      "longitude": 32.2715,
      "id"       : "Ismailia"
    }
  ],
  "path": "Mansoura -> Damietta , Damietta -> Tanta , Tanta -> Ismailia , Ismailia -> Mansoura"
}
```
#Follow me 
#
[<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/github.svg' alt='github' height='40'>](https://github.com/https://gitlab.com/devTaha)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/linkedin.svg' alt='linkedin' height='40'>](https://www.linkedin.com/in/https://www.linkedin.com/in/devahmed94//)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/facebook.svg' alt='facebook' height='40'>](https://www.facebook.com/https://www.facebook.com/engahmedtaha94/)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/twitter.svg' alt='twitter' height='40'>](https://twitter.com/https://twitter.com/a7med_sh3ish3)  [<img src='https://cdn.jsdelivr.net/npm/simple-icons@3.0.1/icons/stackoverflow.svg' alt='stackoverflow' height='40'>](https://stackoverflow.com/users/https://stackoverflow.com/users/6555104/ahmed-taha)
#References
- https://en.wikipedia.org/wiki/Travelling_salesman_problem
- https://www.srimax.com/2016/07/05/travelling-salesman-problem-using-branch-bound-approach-php/ 
