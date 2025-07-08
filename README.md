# Nutrition Solutions Subscription Pause Tool

This repository houses the codebase to rebuild and modernize a critical feature for Nutrition Solutions: allowing customers to pause or adjust their subscriptions via an integration with the updated Keap (Infusionsoft) REST API.


## Folder Structure

- Next.js frontend (not currently in use. Considering moving the account management from Wordpress)
- Current Keap SDK monorepo
- Legacy Keap api downloaded from members.nutritionsolutions.com


🚨 Problem Overview

Cstomers have the ability to request a week off by submitting a form on the membership site, https://members.nutritionsolutions.com. 
When a customer requests off they should not be charged the following week. 
Keap does not provide a way to push back the next bill date natively so we had this custom developed. When the form was submitted users were entered into a campaign which triggered an http post to push their next_bill_date to 7 days later.
The post also allowed us to customize the number of days —positive or negative.

Since Keap’s API upgrade, that functionality broke due to deprecation of the old API and incompatibility with the legacy HTTP POST logic.



## Current Workaround (and Its Risks)

As a temporary fix, we’ve updated the Keap campaign automation to:
	1.	Cancel the customer’s existing subscription when the pause request is submitted.
	2.	Automatically create a new subscription with the first bill date set to the next Thursday (all subscriptions are billed on Thursdays)

This workaround causes issues:
	•	❌ No guarantee the new subscription is created properly.
	•	❌ Credits applied to the old subscription are lost—Keap has no built-in mechanism to transfer them automatically.


## Objective

Rebuild the subscription modification logic using the new Keap REST API and a modern backend, ensuring:
	•	⏩ You can push a customer’s next_bill_date forward by any number of days.
	•	⏪ Or pull it backward for earlier billing if needed.
	•	💵 Credits, metadata, and billing consistency are preserved end-to-end.
	•	💻 A front-end form (or internal tool) triggers this logic reliably.


## Notes on Architecture & Direction

The original implementation was embedded inside the WordPress-based membership site, but we are not committed to repeating that setup. We’re open to building the system in a more modern, flexible environment.

Preferred Direction: Supabase Edge Functions as the Orchestration Layer

We are actively transitioning all business-critical data to Supabase, which we envision becoming the single source of truth across all platforms.

So ideally:
	•	Backend logic for subscription adjustments would be triggered from a Supabase Function or Edge Function.
	•	Customer records, pause history, and sync state would be stored and queried from Supabase.

However, we are open to recommendations on what is most reliable, scalable, and maintainable, especially given Keap’s OAuth 2.0 flow and potential rate-limiting quirks.

## Resources
Keap: Making OAuth Requests without User Authorization	https://developer.infusionsoft.com/tutorials/making-oauth-requests-without-user-authorization/
Keap Personal Access Token & Service Account Keys	https://developer.infusionsoft.com/pat-and-sak/
Keap Postman Collection	https://documenter.getpostman.com/view/2915979/UVByKWEZ
Keap API Sample Code	https://github.com/infusionsoft/API-Sample-Code.git
Keap SDK	https://github.com/infusionsoft/keap-sdk.git
Keap SDK V2 Typescript	https://github.com/infusionsoft/keap-sdk/tree/main/sdks/v2/typescript
Keap Developer Docs	https://developer.infusionsoft.com/docs/restv2/

