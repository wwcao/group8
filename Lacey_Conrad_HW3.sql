-- Question 1. List all state names and their 2-letter codes.
select name, statecode
from states;

-- Question 2. Write a query to	report the information for all counties	whose names start with "Prince".  (Hint: Use "like").	
-- Output columns: name, statecode, populate_1950, population_2010 Order by state code.
select counties.name, states.statecode, counties.population_1950, counties.population_2010
from counties, states
where states.statecode=counties.statecode
and counties.name like "Prince%"
order by states.statecode asc;

-- Question 3. Write a single query to list only the population	in year	2010 for the state represented by Sen. Richard Lugar.
-- Output column: populate_2010
select states.population_2010
from states, senators
where senators.statecodes=states.statecode
and senators.name="Richard Lugar";

-- Question 4. Write a	single query to	report only the	total number of	the counties in	'Maryland'.	
-- The query should not hard-code the state code for Maryland (join the two tables in	the WHERE clause)
select count(counties.name)
from counties, states
where states.statecode=counties.statecode
and states.name="Maryland";

-- Question 5. Write a single query to find the name of the state that was admitted last into the union.
-- Hint: Use nested subquery.
select name
from states
where admitted_to_union=(select max(admitted_to_union)
			from states)
limit 1;

-- Question 6. Find all democratic (i.e., with affiliation = 'D') senators that	are not	chairman of any	committee or sub-committee.			
-- Output columns: name	Order by name.
select distinct senators.name
from senators, committees
where senators.name not in (select committees.chairman from committees)
and senators.name not in (select committees.ranking_member from committees)
and senators.affiliation="D"
order by senators.name asc;
