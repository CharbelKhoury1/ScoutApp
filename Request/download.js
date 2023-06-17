// Code goes here

var app = angular.module('app', []);            
app.controller('FirstCtrl', ['$scope','$http', '$filter', function($scope, $http, $filter){
    
$scope.tableDatas = [
    {name: 'value1', fileName:'Avis Camp', filePath: 'Requests/Avis Camp.docx', selected: true},
    {name: 'value2', fileName:'Avis Sortie', filePath: 'Requests/Avis Sortie.docx', selected: true},
    {name: 'value3', fileName:'Demande Certificats', filePath: 'Requests/Demande Certificats.docx', selected: false},
    {name: 'value4', fileName:'Permission Act Fin', filePath: 'Requests/Permission Act Fin.docx', selected: true},
    {name: 'value5', fileName:'Permission Camp', filePath: 'Requests/Permission Camp.docx', selected: true},
    {name: 'value6', fileName:'Permission Soiree', filePath: 'Requests/Permission Soiree.docx', selected: false},
    {name: 'value7', fileName:'Permission Sortie', filePath: 'Requests/Permission Sortie.docx', selected: false},
    {name: 'value8', fileName:'Programme Annuel', filePath: 'Requests/Programme Annuel.docx', selected: false},
    {name: 'value9', fileName:'Rapport Act Fin', filePath: 'Requests/Rapport Act Fin.docx', selected: false},
    {name: 'value10', fileName:'Rapport Camp', filePath: 'Requests/Rapport Camp.docx', selected: false},
    {name: 'value11', fileName:'Rapport Soiree', filePath: 'Requests/Rapport Soiree.docx', selected: false},
    {name: 'value12', fileName:'Rapport Sortie', filePath: 'Requests/Rapport Sortie.docx', selected: false},
  ];  
$scope.application = [];   

$scope.selected = function() {
    $scope.application = $filter('filter')($scope.tableDatas, {
      checked: true
    });
}

$scope.downloadAll = function(){
    $scope.selectedone = [];     
    angular.forEach($scope.application,function(val){
       $scope.selectedone.push(val.name);
       $scope.id = val.name;        
       angular.element('#'+val.name).closest('tr').find('.downloadable')[0].click();
    });
}         
 
    
}]);