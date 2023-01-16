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

## Must haves

* Use Laravel
* IP address info/calculation is done in PHP
* IP info is retrieved from the web server with JavaScript
* Support IPv4 or IPv6
* Invalid subnets are not accepted
* Instructions how to install and run the code

## Should haves

* Use third party libraries/classes
* Use one or more self-written classes for IP address info/calculation in PHP

## Could haves

* Use a template engine
* Use a version control system and make several commits
* Style the webpage in 'dark mode'
* Support for both IPv4 and IPv6

## Won't haves

\-

## Languages

PHP
HTML
CSS
JavaScript