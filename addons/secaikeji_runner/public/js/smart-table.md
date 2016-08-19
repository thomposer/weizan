#angular.module('myApp',['smart-table']);


<select class="form-control" id="predicate" ng-model="selectedPredicate" ng-options="predicate for predicate in predicates"></select>
<table st-table="displayedCollection" st-safe-src="rowCollection" class="table table-striped">
	<tr>
		<th st-sort="getters.firstName">first name</th>
		<th st-sort="lastName">last name</th>
		<th st-sort="birthDate">birth date</th>
		<th st-sort="balance" st-skip-natural="true" >balance</th>
		<th>email</th>
	</tr>
	<tr>
		<th>
			<input st-search="firstName" placeholder="search for firstname" class="input-sm form-control" type="search"/>
		</th>
		<th>
			<input st-search="firstName" placeholder="search for firstname" class="input-sm form-control" type="search"/>
		</th>
	</tr>
	<tr st-select-row="row" st-select-mode="multiple" ng-repeat="row in rowCollection">
		<td>{{row.firstName | uppercase}}</td>
		<td>{{row.lastName}}</td>
		<td>{{row.birthDate | date}}</td>
		<td>{{row.balance | currency}}</td>
	</tr>
	
	<tr>
		<td class="text-center" st-pagination="" st-items-by-page="10" colspan="4">
		</td>
	</tr>
</table>