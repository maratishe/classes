
// object
var make() { 
	var obj = {};
	obj.name = 'tanaka';
	obj.getName = function() { return this.name; }
	return obj;
}

// actual code
var person = make();
console.log( 'Person', person.getName());