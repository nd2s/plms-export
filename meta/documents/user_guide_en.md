# User Guide

## General
This plugin for plentymarkets 7 implements the export format `refurbed`. It can be used to integrate your system into the _refurbed_ marketplace.

To make use of this plugin you need to have an existing _refurbed_ merchant account.

## Integration
Install this plugin and add a new Elastic Export with following settings:

| Input field      | Setting                                    |
| ----------------:| ------------------------------------------ |
| **Name**         | arbitrary, e.g. `refurbed`                 |
| **Type**         | `Item`                                     |
| **Format**       | `refurbed`                                 |
| **Limit**        | `9999`                                     |
| **Provisioning** | `URL`                                      |
| **Token**        | click "generate token" button on the right |

Save the export and send the newly generated link in the input field **URL** to your _refurbed_ contact.


Refer to the plentymarkets manual [Data export](https://www.plentymarkets.co.uk/manual/data-exchange/exporting-data/#4) for further information about how to create and configure exports.

