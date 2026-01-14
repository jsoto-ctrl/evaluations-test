Scheduler Tools

Administrative tools to set up dbs via IUIE roster data. The IUIE report should be saved as csv, saved in the same directory as these tools,
 and then set as Unix LF via BBEdit before running the first tool.
 
 1. setup_spanport_courses.php: First tool that reads the roster file and populates scheduler.sections with essential roster data, such as
 courses, sections, times, location and instructor names.
 
 2. setup_spanport_users.php: Tool that follows as the second step. Its main task is to go through scheduler.sections, retrieve all instructors' names
 to compare those with the existing names in master.instructors. If found, the tool will grab the username and insert it into scheduler.sections. 
 If a match is not found, the tool will report it as unmatched. The admin running the tool will then need to use the IU Addressbook to enter
 the correct username for that instructor and/or tweak an existing name (correct typo or add/delete a middle name or second last name) so that
 the tool finds a match. Because of this matching, we'll need to add TTs to master.instructors (just first, last and username) without changing
 any default values after entering the name in master.instructors (level=4, no courses set to 1, status=instructor). That way these instructors
 will be ignored by tools designed to set up Ancla (such as populateDBs, htacess, etc.).
 
 3. populate.php: This tool will will grab all necessary fields from scheduler.sections and use them to 
 
 a) create (if not present) or empty an existing master.sections_next,
 b) populate master.sections_next (SWEEET!) with courses, sections, location, days, time, supervisor and instructor's usernames if the IUIE roster has 
 them available at the time of running. Karla prepares the course schedule one year in advance, so this tool can be used at the end of one semester to
 populate that pesky master.sections table, cutting significantly in Ancla setup time for the next academic session. 
 
 !!! In order to activate sections_next, we'll need to rename master.sections to master.sections_something and rename master.sections_next to master.sections. 
 That way we can populate this master table at any time without interfering with the existing master.sections. !!!!!
 
 After all these tasks are done, we'll have all necessary course data for directors to do course assignments. The directors' tool will also gather 
 data from other dbs in order to ensure a correct heads count (sections to be covered + instructors' loads). Those tools will reside in a separate
 directory.
 
 jsoto [Feb 2016]
 