{--------------------------Die Mindhunter unit---------------------------}
{------ Geschrieben fr das Spiel Mindhunter.                    --------}
{------ Geschrieben von Sebastian Sch”nitz.                      --------}
{------ (c) by Sebastian Sch”nitz                                --------}
Unit Min;
 Interface
 Uses Crt;

 Procedure Netzwerkausgaben(Var Datei:Text;Schreiben,Pfad:String);
 Procedure Menue(Var o:Integer;Jein:String);
 Procedure Moduswechsel(Var o:Integer;Jein:String);
 Procedure Anleitung;
 Procedure Koordinatensystem;
 {Procedure Erscheinen;}

 IMPLEMENTATION
 Procedure Netzwerkausgaben(Var Datei:Text;Schreiben,Pfad:String);
 Begin
  ClrScr;
  Assign (Datei, 'Z:\AktuellesNetzwerkgame.mtf');
  ReWrite (Datei);
  REPEAT
   ReadLn (Schreiben);
   IF Schreiben <> 'exit' THEN WriteLn (Datei, Schreiben);
  UNTIL Schreiben = 'exit';
  Close (Datei);
 End;
 Procedure Menue(Var o:Integer;Jein:String);
  Begin
  ClrScr;
  Repeat
   Gotoxy(2,2); WriteLn('ษออออออMenอออออออป');
   Gotoxy(2,3); WriteLn('ฬอออออออออออออออออน');
   Gotoxy(2,4); WriteLn('บ                 บ');
   Gotoxy(2,5); WriteLn('บStart        1   บ');
   Gotoxy(2,6); WriteLn('บ                 บ');
   Gotoxy(2,7); WriteLn('บAnleitung    2   บ');
   Gotoxy(2,8); WriteLn('บ                 บ');
   Gotoxy(2,9); WriteLn('บBeenden      3   บ');
   Gotoxy(2,10);WriteLn('บ                 บ');
   Gotoxy(2,11);WriteLn('ฬอออออออออออออออออน');
   Gotoxy(2,12);WriteLn('บDruecken Sie eineบ');
   Gotoxy(2,13);WriteLn('บvon diesen Zahlenบ');
   Gotoxy(2,14);WriteLn('ศอออออออออออออออออผ');
   ReadLn(o);
   If o=1 then break;
   If o=2 then
     Begin
       Anleitung;
       Readkey;
       Clrscr;
     End;
   If o=3 then
     Begin
       WriteLn('Wollen Sie das Programm wirklich beenden? j/n');
       ReadLn(jein);
       If jein='j' then exit;
       If jein='J' then exit;
       If jein='n' then clrscr;
       If jein='N' then clrscr;
     End;
  Until Jein='exit';
  End;
 Procedure Anleitung;
  Begin
   ClrScr;
   WriteLn('Hallo');
  End;
 Procedure Moduswechsel(Var o:Integer;Jein:String);
  Begin
  ClrScr;
  Repeat
   Gotoxy(2,2); WriteLn('ษอออออModuswahlอออออป');
   Gotoxy(2,3); WriteLn('ฬอออออออออออออออออออน');
   Gotoxy(2,4); WriteLn('บ                   บ');
   Gotoxy(2,5); WriteLn('บMehrspieler    1   บ');
   Gotoxy(2,6); WriteLn('บ                   บ');
   Gotoxy(2,7); WriteLn('บEinzelspieler  2   บ');
   Gotoxy(2,8); WriteLn('บ                   บ');
   Gotoxy(2,9); WriteLn('บZurck         3   บ');
   Gotoxy(2,10);WriteLn('บ                   บ');
   Gotoxy(2,11);WriteLn('ฬอออออออออออออออออออน');
   Gotoxy(2,12);WriteLn('บ Druecken Sie eine บ');
   Gotoxy(2,13);WriteLn('บ von diesen Zahlen บ');
   Gotoxy(2,14);WriteLn('ศอออออออออออออออออออผ');
   ReadLn(o);
   {If o=1 then Mehrspieler;
   If o=2 then}
    If o=3 then

      Begin
       WriteLn('Wollen Sie wiklich zrkkehren? j/n');
       ReadLn(jein);
       If jein='j' then
        Begin
         ClrScr;
         Menue( o,jein);
         break;
        End;

       If jein='J' then exit;
        Begin
         ClrScr;
         Menue( o,jein);
         break;
        End;
       If jein='n' then clrscr;
       If jein='N' then clrscr;
     End;

  Until Jein='exit';
  End;
 Procedure Koordinatensystem;
  Begin
   Textcolor(15);{Weiแe Textfarbe}
   {-XY-Ansicht-----------------------------------------}
   Gotoxy(2,3); Write('Y-Achse');
   Gotoxy(2,4); Write('9I                      ');
   Gotoxy(2,5); Write('8I                      ');
   Gotoxy(2,6); Write('7I                      ');
   Gotoxy(2,7); Write('6I                      ');
   Gotoxy(2,8); Write('5I                      ');
   Gotoxy(2,9); Write('4I                      ');
   Gotoxy(2,10);Write('3I                      ');
   Gotoxy(2,11);Write('2I                      ');
   Gotoxy(2,12);Write('1I                      ');
   Gotoxy(2,13);Write('0+---------');
   Gotoxy(2,14);Write(' 0123456789 X-Achse');
   {-XZ-Ansicht-----------------------------------------}
   Gotoxy(26,3); Write(' 0123456789 X-Achse ');
   Gotoxy(26,4); Write('0+---------');
   Gotoxy(26,5); Write('1I                      ');
   Gotoxy(26,6); Write('2I                      ');
   Gotoxy(26,7); Write('3I                      ');
   Gotoxy(26,8); Write('4I                      ');
   Gotoxy(26,9); Write('5I                      ');
   Gotoxy(26,10);Write('6I                      ');
   Gotoxy(26,11);Write('7I                      ');
   Gotoxy(26,12);Write('8I                      ');
   Gotoxy(26,13);Write('9I                      ');
   Gotoxy(26,14);Write('Z-Achse');
   {-ZY-Ansicht-----------------------------------------}
   Gotoxy(46,3); Write('                 Y-Achse');
   Gotoxy(46,4); Write('                      I9');
   Gotoxy(46,5); Write('                      I8');
   Gotoxy(46,6); Write('                      I7');
   Gotoxy(46,7); Write('                      I6');
   Gotoxy(46,8); Write('                      I5');
   Gotoxy(46,9); Write('                      I4');
   Gotoxy(46,10);Write('                      I3');
   Gotoxy(46,11);Write('                      I2');
   Gotoxy(46,12);Write('                      I1');
   Gotoxy(46,13);Write('             ---------+0');
   Gotoxy(46,14);Write('     Z-Achse 9876543210 ');
  End;
 End.