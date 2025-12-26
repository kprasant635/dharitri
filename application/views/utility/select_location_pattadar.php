<%@ Language=VBScript %>
<%option explicit%>
<%Response.Buffer = True%>
<!--#include file = "../../common/connection.asp"-->
<!--#include file = "../../common/ADOVBS.INC"-->

<%  dim RS,sqlstr,RS_user,rs_loc,RS_Done
	set RS = Server.CreateObject("ADODB.Recordset")
	'response.Write session("u_code")
   
	set RS_Done = Server.CreateObject("ADODB.Recordset")
	set RS_user = Server.CreateObject("ADODB.Recordset")
	set rs_loc = Server.CreateObject("ADODB.Recordset")

	dim ism
	set ism = Server.CreateObject("ISMConverter.clsISMConverter")
   
	dim sql_loc
%>
<% call load_iPlugin("../") %>
<html>
<head>
<%Response.Write "<script Language=""JavaScript"">"
dim i

'sql_loc ="SELECT dist_code,loc_name fROM location where Dist_code<>'00' and subdiv_code='00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000'  order by subdiv_code"
'RS.open sql_loc,conn,1,adLockReadOnly
'if RS.RecordCount>0 then
'	i=0
'	Response.Write "var a_dist = new Array(" & RS.RecordCount & ");" & vbcrlf
'	do while not RS.EOF
'		response.Write "a_dist[" & i & "]='" & RS("dist_code") & "," & RS("loc_name") & "';" & vbcrlf
'		RS.MoveNext
'		i=i+1
'	loop
'end if
'RS.Close

sql_loc ="SELECT dist_code,subdiv_code,loc_name fROM location where Dist_code<>'00' and subdiv_code<>'00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000'  order by subdiv_code"
RS.open sql_loc,conn,1,adLockReadOnly
if RS.RecordCount>0 then
	i=0
	Response.Write "var a_subdiv = new Array(" & RS.RecordCount & ");" & vbcrlf
	do while not RS.EOF
		response.Write "a_subdiv[" & i & "]='" & RS("dist_code") & "," & RS("subdiv_code") & "," & ism.ConvertToIsfoc(RS("loc_name"),"ASBW") & "';" & vbcrlf
		RS.MoveNext
		i=i+1
	loop
end if
RS.Close

sql_loc ="SELECT subdiv_code,Cir_code,loc_name fROM location where Dist_code<>'00' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000' order by subdiv_code,cir_code"
RS.open sql_loc,conn,1,adLockReadOnly
if RS.RecordCount>0 then
	i=0
	Response.Write "var a_cir = new Array(" & RS.RecordCount & ");" & vbcrlf
	do while not RS.EOF
		Response.Write "a_cir[" & i & "]='" & RS("subdiv_code") & "," & RS("Cir_code") & "," & ism.ConvertToIsfoc(RS("loc_name"),"ASBW") & "';" & vbcrlf
		RS.MoveNext
		i=i+1
	loop
end if
RS.Close

sql_loc ="SELECT subdiv_code,Cir_code,Mouza_Pargona_code,loc_name fROM location where Dist_code<>'00' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no = '00' and vill_townprt_code = '00000' order by subdiv_code,Cir_code,Mouza_Pargona_code"
RS.open sql_loc,conn,1,adLockReadOnly
if RS.RecordCount>0 then
	i=0
	Response.Write "var a_Mouza_Pargona = new Array(" & RS.RecordCount & ");" & vbcrlf
	do while not RS.EOF
		Response.Write "a_Mouza_Pargona[" & i & "]='" & RS("subdiv_code") & "," & RS("Cir_code") & "," & RS("Mouza_Pargona_code") & "," & ism.ConvertToIsfoc(RS("loc_name"),"ASBW") & "';" & vbcrlf
		RS.MoveNext
		i=i+1
	loop
end if
RS.Close

sql_loc ="SELECT subdiv_code,Cir_code,Mouza_Pargona_code,Lot_No,loc_name fROM location where Dist_code<>'00' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code = '00000' order by subdiv_code,Cir_code,Mouza_Pargona_code,lot_no"
RS.open sql_loc,conn,1,adLockReadOnly
if RS.RecordCount>0 then
	i=0
	Response.Write "var a_lot = new Array(" & RS.RecordCount & ");" & vbcrlf
	do while not RS.EOF
		Response.Write "a_lot[" & i & "]='" & RS("subdiv_code") & "," & RS("Cir_code") & "," & RS("Mouza_Pargona_code") & "," & RS("lot_no") & "," & ism.ConvertToIsfoc(RS("loc_name"),"ASBW") & "';" & vbcrlf
		RS.MoveNext
		i=i+1
	loop
end if
RS.Close

sql_loc ="SELECT subdiv_code,Cir_code,Mouza_Pargona_code,Lot_No,Vill_townprt_code,loc_name fROM location where Dist_code<>'00' and subdiv_code<>'00' and Cir_code<>'00' and mouza_pargona_code<>'00' and lot_no<>'00' and vill_townprt_code<>'00000' order by subdiv_code,Cir_code,Mouza_Pargona_code,Lot_No,vill_townprt_code"
RS.open sql_loc,conn,1,adLockReadOnly
if RS.RecordCount>0 then
	i=0
	Response.Write "var a_Vill_townprt = new Array(" & RS.RecordCount & ");" & vbcrlf
	do while not RS.EOF
		Response.Write "a_Vill_townprt[" & i & "]='" & RS("subdiv_code") & "," & RS("Cir_code") & "," & RS("Mouza_Pargona_code") & "," & RS("lot_no") & "," & RS("Vill_townprt_code") & "," & replace(ism.ConvertToIsfoc(RS("loc_name"),"ASBW"),"'","\'") & "';" & vbcrlf
		RS.MoveNext
		i=i+1
	loop
end if
RS.Close
%>
</script>
<script Language="JavaScript">
var i,j;
function FilterSubdiv()
{if(Form1.dist_code.selectedIndex==0)
    {Form1.subdiv_code.disabled=true;Form1.subdiv_code.selectedIndex=0;
     Form1.cir_code.disabled=true;Form1.cir_code.selectedIndex=0;
     Form1.mouza_pargona_code.disabled=true;Form1.mouza_pargona_code.selectedIndex=0;
     Form1.lot_no.disabled=true;Form1.lot_no.selectedIndex=0;
     Form1.vill_townprt_code.disabled=true;Form1.vill_townprt_code.selectedIndex=0;
     return false;
    }
 
 Form1.subdiv_code.disabled=false;
 for(i=Form1.subdiv_code.length;i>0;i--)
	Form1.subdiv_code.remove(i);
 j=1;	
 for(i=0;i<a_subdiv.length;i++)
	if(a_subdiv[i].substr(0,2)==Form1.dist_code.value)
	{optionName = new Option(a_subdiv[i].substring(6), a_subdiv[i].substr(3,2))
	 Form1.subdiv_code.options[j]=optionName;
	 j++;
	}
}

function FilterCir()
{if(Form1.subdiv_code.selectedIndex==0)
    {Form1.cir_code.disabled=true;Form1.cir_code.selectedIndex=0;
     Form1.mouza_pargona_code.disabled=true;Form1.mouza_pargona_code.selectedIndex=0;
     Form1.lot_no.disabled=true;Form1.lot_no.selectedIndex=0;
     Form1.vill_townprt_code.disabled=true;Form1.vill_townprt_code.selectedIndex=0;
     return false;
    }
 Form1.cir_code.disabled=false;
 for(i=Form1.cir_code.length;i>0;i--)
	Form1.cir_code.remove(i);
 j=1;
 
 for(i=0;i<a_cir.length;i++)
	if(a_cir[i].substr(0,2)==Form1.subdiv_code.value)
	{optionName = new Option(a_cir[i].substring(6), a_cir[i].substr(3,2))
	 Form1.cir_code.options[j]=optionName;
	 j++;
	}
}

function FilterMouzaPargona()
{if(Form1.cir_code.selectedIndex==0)
    {Form1.mouza_pargona_code.disabled=true;Form1.mouza_pargona_code.selectedIndex=0;
     Form1.lot_no.disabled=true;Form1.lot_no.selectedIndex=0;
     Form1.vill_townprt_code.disabled=true;Form1.vill_townprt_code.selectedIndex=0;
     return false;
    }
 Form1.mouza_pargona_code.disabled=false;
 for(i=Form1.mouza_pargona_code.length;i>0;i--)
	Form1.mouza_pargona_code.remove(i);
 j=1;
 for(i=0;i<a_Mouza_Pargona.length;i++)
	if(a_Mouza_Pargona[i].substr(0,2)==Form1.subdiv_code.value&&a_Mouza_Pargona[i].substr(3,2)==Form1.cir_code.value)
	{optionName = new Option(a_Mouza_Pargona[i].substring(9), a_Mouza_Pargona[i].substr(6,2))
	 Form1.mouza_pargona_code.options[j]=optionName;j++;
	}
}

function FilterLot()
{if(Form1.mouza_pargona_code.selectedIndex==0)
    {Form1.lot_no.disabled=true;Form1.lot_no.selectedIndex=0;
     Form1.vill_townprt_code.disabled=true;Form1.vill_townprt_code.selectedIndex=0;
     return false;
    }
 Form1.lot_no.disabled=false;
 for(i=Form1.lot_no.length;i>0;i--)
	Form1.lot_no.remove(i);
 j=1;
 for(i=0;i<a_lot.length;i++)
	if(a_lot[i].substr(0,2)==Form1.subdiv_code.value&&a_lot[i].substr(3,2)==Form1.cir_code.value&&a_lot[i].substr(6,2)==Form1.mouza_pargona_code.value)
	{optionName = new Option(a_lot[i].substring(12), a_lot[i].substr(9,2))
	 Form1.lot_no.options[j]=optionName;j++;
	}
//alert(Form1.subdiv_code.value+'\n'+Form1.cir_code.value+'\n'+Form1.mouza_pargona_code.value);	
}

function FilterVillTown()
{if(Form1.lot_no.selectedIndex==0)
    {Form1.vill_townprt_code.disabled=true;Form1.vill_townprt_code.selectedIndex=0;
     return false;
    }
 Form1.vill_townprt_code.disabled=false;
 for(i=Form1.vill_townprt_code.length;i>0;i--)
	Form1.vill_townprt_code.remove(i);
 j=1;
 for(i=0;i<a_Vill_townprt.length;i++)
	if(a_Vill_townprt[i].substr(0,2)==Form1.subdiv_code.value&&a_Vill_townprt[i].substr(3,2)==Form1.cir_code.value&&a_Vill_townprt[i].substr(6,2)==Form1.mouza_pargona_code.value&&a_Vill_townprt[i].substr(9,2)==Form1.lot_no.value)
	{optionName = new Option(a_Vill_townprt[i].substring(18), a_Vill_townprt[i].substr(12,5))
	 Form1.vill_townprt_code.options[j]=optionName;j++;
	}
}
</script>
</head>
<BODY > 

  <p align="center" style="margin-top: 3; margin-bottom: 3">&nbsp;	<font face="Arial" size="3">[<a href="../menu.asp">Home</a>]
	</font>
</p>

			<table width="918" cellpadding="2" border="1" bordercolor="#99CCFF" style="border-collapse: collapse" cellspacing="0">
	<tr>	
		<td bgcolor="#6699FF" align=center style="border-left-color: #99CCFF; border-left-width: 1; border-right-color: #99CCFF; border-right-width: 1; border-top-color: #99CCFF; border-top-width: 1" width="912">
			<p dir="ltr">
<font face="Arial" size="4" color="#FFFFFF">Pattadar Deletion</font></td>
	</tr>	
	</table>

	<div align="center">
</div>
</p>
<p></p>
<p style="margin-top: 0; margin-bottom: 0"> 
         <p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
         <div align="center">
           <center> 
         <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#FF9900" width="43%" id="AutoNumber5" bgcolor="#FFFFCC" height="84">
          <tr>
            <td width="100%" align="right" height="18" colspan="2" bgcolor="#FF9900" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1">
            <p align="left" style="margin-top: 6; margin-bottom: 6">
            <FONT face="ASBW-TTDurga" color=WHITE style="font-size: 18pt"><b>&nbsp;Î—ôš 
            Øþôêëþ ¢‡ˆý -</b></FONT></td>
          </tr>
<form name=Form1 method=post action="select_pattadar.asp">
          <tr>
            <td width="38%" align="right" height="1" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1">
            <p style="margin-top: 3; margin-bottom: 0">
            <font style="font-size: 18pt">êÿ¢ô&nbsp;&nbsp; </font></td>
            <td width="62%" height="1" style="border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1; font-size:16pt">
            <p style="margin-top: 3; margin-bottom: 0">
            <p style="margin-top: 3; margin-bottom: 0"><font size="2" face="Courier New">
            <SELECT name=dist_code style="font-family: ASBW-TTDurga; font-size: 16pt" onChange="FilterSubdiv()" tabindex="1" >
                <option selected>- Øþôêëþ ¢‡ˆý -</option>

					<%'DISTRICT SELECTION----------------
						sql_loc = "SELECT * FROM location WHERE dist_code<>'00' and subdiv_code = '00' and cir_code = '00' and mouza_pargona_code = '00' and lot_no = '00' and vill_townprt_code = '00000'"
						rs_loc.Open sql_loc,conn,adOpenDynamic,adLockOptimistic
						do while not rs_loc.EOF
							Response.Write "<option value=" & rs_loc("dist_code") & ">" &  ism.ConvertToIsfoc(rs_loc("loc_name"),"ASBW") & "</option>"
							rs_loc.movenext
						loop
						rs_loc.Close
					%>
            </select>
            </td>
          </tr>
           <tr>
            <td width="38%" align="right" height="28" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1">
            <font style="font-size: 18pt" color="#000080">Ÿ¦þˆÚýŸô&nbsp;&nbsp;
            </font></td>
            <td width="62%" height="28" style="border-right-style: solid; border-right-width: 1; font-size:16pt">
            <font size="2" face="Courier New">
            <SELECT name=subdiv_code onChange="FilterCir()" style="font-family: ASBW-TTDurga; font-size: 16pt" disabled tabindex="2">
                <option selected>- Øþôêëþ ¢‡ˆý -</option>
				<%'Sub Div SELECTION----------------
				%>
            </select></td>
           </tr>
           <tr>
            <td width="38%" align="right" height="28" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1">
            <span style="font-size: 18pt">îýˆãý&nbsp;&nbsp; </span></td>
            <td width="62%" height="28" style="border-right-style: solid; border-right-width: 1; font-size:16pt">
            <p style="margin-top: 3; margin-bottom: 0"><font size="2" face="Courier New">
            <!--Circle SELECTION---------------->
            <SELECT name=cir_code onChange="FilterMouzaPargona()" style="font-family: ASBW-TTDurga; font-size: 16pt" disabled tabindex="3">
            	<option selected>- Øþôêëþ ¢‡ˆý -</option>
            </select></td>
           </tr>
           <tr>
            <td width="38%" align="right" height="28" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1">
            <font color="#000080"><span style="font-size: 18pt">óŸõÿô&nbsp;&nbsp;
            </span></font></td>
            <td width="62%" height="28" style="border-right-style: solid; border-right-width: 1; font-size:16pt">
            <font size="2" face="Courier New">
            <!--Mouza SELECTION---------------->
            <SELECT name=mouza_pargona_code onChange="FilterLot()" style="font-family: ASBW-TTDurga; font-size: 16pt" disabled tabindex="4">
                <option selected>- Øþôêëþ ¢‡ˆý -</option>
            </select></td>
           </tr>
           <tr>
            <td width="38%" align="right" height="28" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1">
            <span style="font-size: 18pt">¢ô”å&nbsp;&nbsp; </span></td>
            <td width="62%" height="28" style="border-right-style: solid; border-right-width: 1; font-size:16pt">
            <p style="margin-top: 3; margin-bottom: 0"><font size="2" face="Courier New">
            <!--Lot SELECTION---------------->
            <SELECT name=lot_no onChange="FilterVillTown()" style="font-family: ASBW-TTDurga; font-size: 16pt" disabled tabindex="5">
            	<option selected>- Øþôêëþ ¢‡ˆý -</option>
            </select></td>
           </tr>
           <tr>
            <td width="38%" align="right" height="28" style="font-family: ASBW-TTDurga; font-size: 16pt; border-left-style:solid; border-left-width:1; border-bottom-style:solid; border-bottom-width:1">
            <font color="#000080"><span style="font-size: 18pt">Šôª‡/îý¦þÏ&nbsp;&nbsp;
            </span></font></td>
            <td width="62%" height="28" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; font-size:16pt">
            <font size="2" face="Courier New">
            <!--Village SELECTION---------------->
            <SELECT name=vill_townprt_code  onchange="Javascript:if(Form1.vill_townprt_code.selectedIndex>0)
                                                        Form1.proceed.disabled=false;
                                                       else Form1.proceed.disabled=true;"
             style="font-family: ASBW-TTDurga; font-size: 16pt" disabled tabindex="6">
            	<option selected>- Øþôêëþ ¢‡ˆý -</option>
            </select></td>
           </tr>
           </table></center>
</div>
</p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
</p>

  <p style="MARGIN-TOP: 12px; MARGIN-BOTTOM: 12px" align="center">
  <font size="1" face="Courier New">
  <input type="submit" value="Proceed &gt;&gt;" name="proceed" style="font-family: ASBW-TTDurga; font-size: 16pt; color: #0000FF" tabindex="7" ></font></p>
</form></BODY>
<head>
<script Language="JavaScript">
<%if session("dist_code")<>"" then%>
	Form1.dist_code.value='<%=session("dist_code")%>';
	FilterSubdiv();
<%else%>
	Form1.dist_code.focus();
<%end if
  if session("subdiv_code")<>"" then%>
	Form1.subdiv_code.value='<%=session("subdiv_code")%>';
	FilterCir();
<%else%>
	if(!Form1.subdiv_code.disabled) Form1.subdiv_code.focus();
<%end if
  if session("cir_code")<>"" then%>
	Form1.cir_code.value='<%=session("cir_code")%>';
	FilterMouzaPargona();
<%else%>
	if(!Form1.cir_code.disabled) Form1.cir_code.focus();
<%end if
  if session("mouza_pargona_code")<>"" then%>
	Form1.mouza_pargona_code.value='<%=session("mouza_pargona_code")%>';
	Form1.proceed.disabled=false;
	FilterLot();
<%else%>
	if(!Form1.mouza_pargona_code.disabled) Form1.mouza_pargona_code.focus();
	Form1.proceed.disabled=true;
<%end if
  if session("lot_no")<>"" then%>
	Form1.lot_no.value='<%=session("lot_no")%>';
	FilterVillTown();
<%else%>
	if(!Form1.lot_no.disabled) Form1.lot_no.focus();
<%end if
  if session("vill_townprt_code")<>"" then%>
	Form1.vill_townprt_code.value='<%=session("vill_townprt_code")%>';
<%else%>
	if(!Form1.vill_townprt_code.disabled) Form1.vill_townprt_code.focus();
<%end if%>
</script></head>
</html>
<%
set RS_user=nothing
set RS=nothing
Conn.Close
  set Conn=nothing
%>