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

## Requirements
- PHP8.0.2 (I could not find and configure a working earlier version to download)
- composer

## Setup instructions

- clone the project locally `git clone git@github.com:cehmke91/IPcalcavel.git`.
- from the project directory run `php artisan serve` to run a local server.
- In a web browser, go to `http://127.0.0.1:8000` or where artisan is serving to see the Project.

## Thoughts

The main app view is generated from `View/HomeController`. It would also be possible to
make simple view routes. In this instance there would not be much difference but if variables need to be passed into
views I think it's cleaner to use invokable controllers to generate the views in this way. This contains the logic
within the controller.

A form component `subnetRangeCalcForm` resides on this Home view.
I decided to use the twig templating engine as you mentioned that you were using or planning on using it.
This form performs a simple AJAX call to the api controller `SubnetInfoController` then displays
the output on the page.
As it stands the component imports an external script file, I am curious as to your thoughts on including
the script within the component. In doing so the component would be more self-contained as is the case with
components in React / Vue. This may however conflict with CSS preprocessors:

The CSS in its' current form (residing in the public library) was a result of the `asset` function not going well
with twig. There may be some configuration still missing. Ideally I would prefer to use a preprocessor such as SCSS,
this would also mean the classnames can be less verbose due to how styling gets rearranged. 

The api controller uses a custom rule to validate the subnet and then passes it on to the `IPAddressService`
where the business logic is performed. Again I find it to be cleaner to not clutter controllers with business logic,
their purpose should be to direct 'traffic' in the application. The actual logic and processing should reside elsewhere.
This is also where you will find the calculation logic.

I chose to use AJAX to retrieve the information from the webserver mostly because it's a simple interface. Axios is the obvious
replacement but I'm unfimiliar with it, and given that the twig templates seem to be missing some functionality at the moment
I chose to instead use something known in the interest of time. This would likely also be an improvement in allowing twig to
format numbers to be more readable.

Were I to extend this project further I would first look at also working with IPv6, following that I would spend more time
on fixing the twig bridge so that the frontend assets can be properly bundled and accessed. Beyond that unit tests would also
be a good idea.