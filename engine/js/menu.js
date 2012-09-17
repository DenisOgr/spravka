//  ��������� ���������� ����������
cm=null;                    // ���� ����� ���������� 
cp=null;
// ������� ����. ��������� 
// �������� - null.
hide_delay=500;       // ����� �������� (� �.�.) ����-����.
// ����. 
tstat=0;                  // ������� ���������� ������� ����-����.

// ���������� ������� ������������

isNS4 = (document.layers) ? true : false;
isIE4 = (document.all && !document.getElementById) ? true : false;
isIE5 = (document.all && document.getElementById) ? true : false;
isNS6 = (!document.all && document.getElementById) ? true : false;


// ������� ������������ � ���������� ����

// ����:
// objElement - �������������(id) ����;
// bolVisible - ������ ����������:
// true  - ���������� ����;
// false - ������ ����.

// �����:
// 1


// P.S: � ����������� �� ���� ��������
// �������� ��� ����������� � ���������� ����
// ��������� �����������.

function switchDiv(objElement,bolVisible){
if(isNS4||isIE4){
if(!bolVisible) {
objElement.visibility ="hidden"
} else {
objElement.visibility ="visible"
}     
} else if (isIE5 || isNS6) {
if(!bolVisible){
objElement.style.display = "none";

} else {
objElement.style.display = "";

}

}

return 1;
}



// ������� ������������ �������� ���������� �� 
// �������� ������� (�� ����������� ����).

// ����:
// el    - ������������� ��������;
// sProp - �������� (left,top...)

// �����:
// �������� ������-������ �������� �������.



function getPos(el,sProp) {
var iPos = 0;
while (el.offsetParent) {
iPos+=(el["offset" + sProp]-el["scroll" + sProp]);
el = el.offsetParent;
}
return iPos;

}



// ������� ����� ������ � ���������
// �� ���������.

// ����:
// myid - �������� �������

// �����: ������.

function getelementbyid(myid) {
if (isNS4){
objElement = document.layers[myid];
}else if (isIE4) {
objElement = document.all[myid];
}else if (isIE5 || isNS6) {
objElement = document.getElementById(myid);
}
return(objElement);
}



// ������� ������������|����������
// ,� �������������� ��� � �������������
// ������� ������� ����.


// ����:
// el - ������� ������� �� ������� 
// ��������� ���������;
// m  - ������������ ����, ������� ����
// ���������� ��� ���� ��������.

function show(el,m,p) {

// ���� ������� ������� ����,
// ������� ��� ���������.
if (typeof cp != "undefined" && cp!= null) {
switchDiv(cp,false);
}
if (cm!=null && p=='0') {
switchDiv(cm,false);
}


// ���� ������� �������� ���� ��� �����������,
// ��:
// 1) �������� ��� ������;
// 2) X ���� = X �������;
// 3) Y ���� = Y ������� + ������ �������;
// 4) ������ ���� �������;
// 5) ��������� ����� ���� � cm.  


if (m!=null) {
m=getelementbyid(m);
if (p=='0'){
m.style.left = getPos(el,"Left")-getPos(getelementbyid('div_main'),"Left")+"px";
} else m.style.left = getPos(el,"Left")-el.offsetWidth-getPos(getelementbyid('div_main'),"Left")-20+"px";
m.style.top =  getPos(el,"Top")+el.offsetHeight+"px";
switchDiv(m,true);
if (p=='1'){
cp=m;
} else cm=m;

}

}



// ������� "�����������" ����.

// ������� ������ �� ��������� �� ����
// � ���������� 1.

function hidemenu() {

// ������������� �������� ������ 
// hide_delay �.�. � ������� �������; 

timer1=setTimeout("show(null,null,0)",hide_delay);

// ������������� tstat=1 - �������, ����, ��� ������ �������.
tstat=1;

return 1;
}



// �������, ��������������� ������ ����������
// ������� ��������. ����� �������,
// ���� �� ���������.

// ������� ������ �� ��������� �� ����
// � ���������� 1.

function cancelhide() {
if (typeof tstat != "undefined" && tstat==1) {
clearTimeout(timer1);
tstat=0;
}
return 1;
}