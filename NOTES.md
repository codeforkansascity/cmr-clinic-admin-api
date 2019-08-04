Change Applicant Status to Summary, then create a true status field. #10

Change Applicant Status to Summary

During expungement day users needed to leave more information about the status of an applicant that they were working on that would fit in a word or two.  They used that status field to communicate the current state or what needed to happen next to the applicant.

- [ ] Backend changes
- [ ] Rename `status` field to `summary`.
- [ ] Rename Status label to Summary

<img width="541" alt="Screen Shot 2019-07-06 at 3 05 22 PM" src="https://user-images.githubusercontent.com/447024/60760844-a7139280-a001-11e9-960b-cee833decaa0.png">


* `status` has been renamed to `notes`
* Status is being replaced with the concept of steps since we go through the process in steps.  We want to record who and when a step was changed.
     * Create a table called `steps` with foreign keys of `client_id` and `status_id`
     * The `clients` table will have a foreign key of `steps_id` pointing to the current step.


Setup permissions for users #6

At this time we think we will have the following types of users:

* Clinic User - Has almost all permissions
* Volunteer Lawyer - Cannot add or delete an Applicant/Client, but can 
   * edit Applicant/Client
   * add, edit, remove convictions, charges, and  service 

- [ ] Work with backend developers to determine how to pass the user's role.

