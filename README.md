# UTM Tracker Wordpress Plugin

## What does it do?
It adds UTM parameters, GCLID and other information and stores via website cookie for 30 days. It can then be inserted into any lead generation form. It adds this extra information as hidden fields on a form.

This is a fork of script utm_form https://github.com/medius/utm_form, made into a Wordpress Plugin and modifed to add GCLID, adpos, net and match variables.

## Why do I need it?
Google created UTM parameters to help track referrals so you know the exact source of your website traffic.

If you want to know where each email list subscriber or lead is coming from, use this script to help with that. This
is different from analytics tools where you know this information in aggregate.

e.g. You'll know that bob@example.com originally came from Twitter, landed on page www.yoursite.com/promotion and
visited your website 3 times before giving you his email address.

**Information it adds to your forms:**
* 5 UTM parameters - Any UTM parameters in the URL that a visitor used to come to your website will be added to the form
* GCLID - Google creates a unique id that is passed when using a visitor comes from an ad on their service.
* adpos - The position of the Google ad on the page.
* net - The network source of the traffic from Google.
* match - The keyword matching from the ad displayed on Google.

## How do I use it?


1. Install and activate the Wordpress plugin on your website.

2. You need to make your forms accept the new fields. Based on the information available for a visitor, the fields added
  to your form will be,

  * USOURCE - Value of *utm_source* if present
  * UMEDIUM - Value of *utm_medium* if present
  * UCAMPAIGN - Value of *utm_campaign* if present
  * UCONTENT - Value of *utm_content* if present
  * UTERM - Value of *utm_term* if present
  * IGCLID - Value of the *gclid* if present
  * IADPOS - Value of the *adpos* if present
  * INET - Value of the *net* if present
  * IMATCH - Value of the *match* if present
  
## How will my form look like?

Let's say your lead generation form looks like this before the script is added.
```html
<form action="//terminusapp.us6.list-manage.com/subscribe/" method="post">
  <label for="mce-email">Email Address</label>
  <input type="email" value="" name="email" id="mce-email">
  <input type="submit" value="Subscribe" name="subscribe">
</form>
```

Once the script is added, your form will look like this after the page is loaded.

```html
<form action="//terminusapp.us6.list-manage.com/subscribe/" method="post">
  <input type="hidden" name="USOURCE" value="twitter">
  <input type="hidden" name="UMEDIUM" value="social">
  <input type="hidden" name="UCAMPAIGN" value="awareness">

  <label for="mce-email">Email Address</label>
  <input type="email" value="" name="email" id="mce-email">
  <input type="submit" value="Subscribe" name="subscribe">
</form>
```

When someone submits the form, all the extra information is also sent along with the email address.

You'll need to make sure that your form can accept these values. If it is a Mailchimp form, configure it to
accept these fields. Same for ConstantContact, CampaignMonitor, Hubspot or any other service.

## More Questions?
#### What happens if someone visits a bunch of pages on my website/blog before filling the form?
It doesn't matter. As soon as they land on your website, the script saves the information in a cookie. This
cookie is valid for 30 days. It adds this information to your form from the saved cookie.
