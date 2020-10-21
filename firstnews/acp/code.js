function AddText(text, element)
{
  if(element == 'info_box')
  {
    if (document.acp_form.info_box.createTextRange && document.acp_form.info_box.caretPos)
    {
      var caretPos = document.acp_form.info_box.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
      text + ' ' : text;
    }
    else document.acp_form.info_box.value += text;
    document.acp_form.info_box.focus(caretPos)
  }

  if(element == 'description')
  {
    if (document.acp_form.description.createTextRange && document.acp_form.description.caretPos)
    {
      var caretPos = document.acp_form.description.caretPos;
      caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
      text + ' ' : text;
    }
    else document.acp_form.description.value += text;
    document.acp_form.description.focus(caretPos)
  }
}

function image(element)
{
  imagetitle = prompt("Titel der Grafik: (otpional)","");
  imagelocation = prompt("Bitte geben Sie den Pfad der einzufügenden Grafik an:","http://");

  if ((imagelocation != null) && (imagelocation != ""))
  {
    if ((imagetitle != null) && (imagetitle != ""))
    {
      AddTxt = '<img src="' + imagelocation + '" alt="' + imagetitle + '" border="0">';
      AddText(AddTxt);
    }
    else
    {
      AddTxt = '<img src="' + imagelocation + '" alt="" border="0">';
      AddText(AddTxt, element);
    }
  }
}

function pre(element)
{
  AddTxt="<pre></pre>";
  AddText(AddTxt, element);
}

function email(element)
{
  mailtitle = prompt("Titel des Verweises: (otpional)","");
  maillocation = prompt("Bitte geben Sie eine Mailadresse an:","mailto:");

  if ((maillocation != null) && (maillocation != ""))
  {
    if ((mailtitle != null) && (mailtitle != ""))
    {
      AddTxt = '<a href="' + maillocation + '">' + mailtitle + '</a>';
      AddText(AddTxt, element);
    }
    else
    {
      AddTxt = '<a href="' + maillocation + '">' + maillocation + '</a>';
      AddText(AddTxt, element);
    }
  }
}

function table(element)
{
  rows = parseInt(prompt("Anzahl der Zeilen: (nur ganze Zahlen)","1"));
  cols = parseInt(prompt("Anzahl der Spalten: (nur ganze Zahlen)","1"));

  AddTxt = '<table bgcolor="" cellpadding="" cellspacing="" border="0" width="" height="">\r\n';

  if(rows != "NaN" && cols != "NaN")
  {
    for(var row = 0; row < rows; row++)
    {
      AddTxt = AddTxt + '<tr height="">\r\n';

      for(var col = 0; col < cols; col++) AddTxt = AddTxt + ' <td bgcolor="" width=""></td>\r\n';

      AddTxt = AddTxt + '</tr>\r\n';
    }
  }

  AddTxt = AddTxt + '</table>';
  AddText(AddTxt, element);
}

function bold(element)
{
  AddTxt="<b></b>";
  AddText(AddTxt, element);
}

function italicize(element)
{
  AddTxt="<i></i>";
  AddText(AddTxt, element);
}

function center(element)
{
  AddTxt='<div align="center"></div>';
  AddText(AddTxt, element);
}

function url(element)
{
  urltitle = prompt("Titel der Zielseite: (otpional)","");
  urllocation = prompt("Bitte geben Sie ein Verweisziel an:","http://");

  if ((urllocation != null) && (urllocation != ""))
  {
    if ((urltitle != null) && (urltitle != ""))
    {
      AddTxt = '<a href="' + urllocation + '">' + urltitle + '</a>';
      AddText(AddTxt, element);
    }
    else
    {
      AddTxt = '<a href="' + urllocation + '">' + urllocation + '</a>';
      AddText(AddTxt, element);
    }
  }
}

function underline(element)
{
  AddTxt="<u></u>";
  AddText(AddTxt, element);
}
