# UTM Tracker Wordpress Plugin

## What does it do?
When passing UTM parameters, GCLID, and other parameters to your website it stores this info via a website cookie for 30 days. It can then be inserted into any lead generation form on your website. It automatically adds this extra information as hidden fields on your HTML form.

This is a fork of script utm_form https://github.com/medius/utm_form, and made into a Wordpress Plugin. It has been modified to already include `gclid`, `adpos`, `net` and `match` variables to better help track Google Ads.

## Why do I need it?
Google created UTM parameters to help track referrals so you know the exact source of your website traffic.

If you want to know where each email list subscriber is coming from, use this script to help with that. This
is different from analytics tools where you know this information in aggregate.

** Example: **

https://www.yoursite.com/?utm_source=facebook&utm_medium=cpc&utm_campaign=myad&utm_content=version2

The user Bob visits your contact form at https://www.yoursite.com/contact/ and submits his email address bob@example.com to your MailChimp mailing list.

From the information stored in MailChimp you'll know that Bob came from a paid Facebook ad with the campaign "myad" and was the second version of your ad.

So you can attribute the source of traffic or conversions and know how effective your ad campaigns have been.

**Information it adds to your forms:**
* utm_source - The platform (or vendor) where the traffic originates, like Facebook or your email newsletter.
* utm_medium - You can use this to identify the medium like Cost Per Click (CPC), social media, affiliate or QR code.
* utm_campaign - This is just to identify your campaign. Like your website or a specific product promotion.
* utm_content - If you’re A/B testing ads, then this is a useful metric that passes details about your ad. You can also use it to differentiate links that point to the same URL.
* utm_term – You’ll use this mainly for tracking your keywords during a paid Google Ads campaign. You can also use it in your display ad campaigns to identify aspects of your audience.
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

This information is added automatically to the HTML form and no additional coding is needed.

When someone submits the form, all the extra information is also sent along with the email address.

You'll need to make sure that your form can accept these values. If it is a Mailchimp form, configure it to
accept these fields. Same for ConstantContact, CampaignMonitor, Hubspot or any other service.

## Questions?
#### What happens if someone visits a bunch of pages on my website/blog before filling the form?
It doesn't matter. As soon as they land on your website, the script saves the information in a cookie. This
cookie is valid for 30 days. It adds this information to your form from the saved cookie.
