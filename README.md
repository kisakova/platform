AddressBundle
=============

the OroAddressBundle implement basic address storage and country/region storage. It provides PHP/REST/SOAP API for address CRUD operations.

**Basic Docs**

* [Installation](#installation)
* [Usage](#usage)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle and the library

Add on composer.json (see http://getcomposer.org/)

    "require" :  {
        // ...
        "oro/OroAddress": "dev-master",
    }

### Step 2) Register the bundle

To start using the bundle, register it in your Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Oro\Bundle\AddressBundle\OroAddressBundle(),
    );
    // ...
}
```

### Dependencies

* FOSRestBundle https://github.com/FriendsOfSymfony/FOSRestBundle
* BeSimpleSoapBundle, https://github.com/BeSimple/BeSimpleSoapBundle
* DoctrineBundle, https://github.com/doctrine/DoctrineBundle
* FlexibleEntityBundle, https://github.com/laboro/FlexibleEntityBundle

<a name="usage"></a>

## Usage

### PHP API

``` php
<?php
    //Accessing address manager from controller
    /** @var  $addressManager \Oro\Bundle\AddressBundle\Entity\Manager\AddressManager */
    $addressManager = $this->get('oro_address.address.provider')->getStorage();

    //create empty address entity
    $address = $addressManager->createFlexible();

    //process insert/update
    $this->get('oro_address.form.handler.address')->process($entity)

    //accessing address form service
    $this->get('oro_address.form.address')
```

### REST API

<pre>
    oro_api_delete_address    DELETE        /api/rest/{version}/address.{_format}
    oro_api_get_address       GET           /api/rest/{version}/addresses/{id}.{_format}
    oro_api_get_addresses     GET           /api/rest/{version}/addresses.{_format}
    oro_api_post_address      POST          /api/rest/{version}/address.{_format}
    oro_api_put_address       PUT           /api/rest/{version}/address.{_format}
</pre>
