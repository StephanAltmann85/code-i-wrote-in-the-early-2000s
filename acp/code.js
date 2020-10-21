function AddText(text)
{
  if (document.acp_form.textarea.createTextRange && document.acp_form.textarea.caretPos)
  {
    var caretPos = document.acp_form.textarea.caretPos;
    caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?
    text + ' ' : text;
  }
  else document.acp_form.textarea.value += text;
  document.acp_form.textarea.focus(caretPos)
}

function email()
{
  mailtitle = prompt("Titel des Verweises: (otpional)","");
  maillocation = prompt("Bitte geben Sie eine Mailadresse an:","mailto:");

  if ((maillocation != null) && (maillocation != ""))
  {
    if ((mailtitle != null) && (mailtitle != ""))
    {
      AddTxt = '[EMAIL=' + maillocation + ']' + mailtitle + '[/EMAIL]';
      AddText(AddTxt);
    }
    else
    {
      AddTxt = '[EMAIL]' + maillocation + '[/EMAIL]';
      AddText(AddTxt);
    }
  }
}

function bold()
{
  AddTxt="[b][/b]";
  AddText(AddTxt);
}

function quote()
{
  AddTxt="[quote][/quote]";
  AddText(AddTxt);
}

function italicize()
{
  AddTxt="[i][/i]";
  AddText(AddTxt);
}

function center()
{
  AddTxt='[align="center"][/align]';
  AddText(AddTxt);
}

function url()
{
  urltitle = prompt("Titel der Zielseite: (otpional)","");
  urllocation = prompt("Bitte geben Sie ein Verweisziel an:","http://");

  if ((urllocation != null) && (urllocation != ""))
  {
    if ((urltitle != null) && (urltitle != ""))
    {
      AddTxt = '[url=' + urllocation + ']' + urltitle + '[/url]';
      AddText(AddTxt);
    }
    else
    {
      AddTxt = '[url]' + urllocation + '[/url]';
      AddText(AddTxt);
    }
  }
}

function underline()
{
  AddTxt="[u][/u]";
  AddText(AddTxt);
}