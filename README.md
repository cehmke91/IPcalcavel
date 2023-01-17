# IPcalcavel

## Challenge

Set-up a webpage with the Laravel framework in which a subnet (IP) can be entered via a text field,
resulting in info about the subnet: first IP address, last IP address, network address and number of usable hosts.

F.e.:

Filled in: 213.136.12.128/27

Output:

```
  network: 213.136.12.128
  first: 213.136.12.129
  last: 213.136.12.158
  hosts: 30
```

---

Filled in: 2001:db8:85a3:8a2e::/64

Output:

```
  network: 2001:0db8:85a3:8a2e::
  first: 2001:0db8:85a3:8a2e:0000:0000:0000:0000
  last: 2001:0db8:85a3:8a2e:ffff:ffff:ffff:ffff
  hosts: 18446744073709551616
```

Take into account that the general idea for the code created should be that the code will be used in a larger web-based application.

## Setup instructions

- from the project directory run `php artisan serve` to run a local server.
- In a web browser, go to `http://127.0.0.1:8000` to see the project.


## Things done
- BONUS: 80 chars
- install twig bridge
- install sushi
- imported a custom font
- Create a basic page layout in twig
- Shift the router to use controllers
- Created a custom validation rule