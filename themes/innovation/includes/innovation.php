<?php

use \Drupal\Component\Utility\Html;
use \Drupal\Core\Render\Element;
use \Drupal\Core\Render\Markup;

class InnovationTheme extends stdClass{
  var $layouts = null;
  var $layout = 0;
  var $theme = 'innovation';
  var $style = 'wide';
  var $defaultLayoutStr = 'W3sia2V5IjoiZGVmYXVsdCIsInRpdGxlIjoiRGVmYXVsdCIsInNlY3Rpb25zIjpbeyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJ0b3AiLCJzdGlja3kiOmZhbHNlLCJ0aXRsZSI6IlRvcCIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6MCwicmVnaW9ucyI6W3siY29sbGciOjYsImNvbG1kIjo2LCJjb2xzbSI6MTIsImNvbHhzIjoxMiwiY29sbGdvZmZzZXQiOjAsImNvbG1kb2Zmc2V0IjowLCJjb2xzbW9mZnNldCI6MCwiY29seHNvZmZzZXQiOjAsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6InRvcF9sZWZ0IiwidGl0bGUiOiJUb3AgTGVmdCIsIndlaWdodCI6MH0seyJjb2xsZyI6NiwiY29sbWQiOjYsImNvbHNtIjoxMiwiY29seHMiOjEyLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidG9wX3JpZ2h0IiwidGl0bGUiOiJUb3AgUmlnaHQiLCJ3ZWlnaHQiOjF9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJoZWFkZXIiLCJzdGlja3kiOnRydWUsInRpdGxlIjoiSGVhZGVyIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjoxLCJyZWdpb25zIjpbeyJjb2xsZyI6IjMiLCJjb2xtZCI6IjMiLCJjb2xzbSI6IjMiLCJjb2x4cyI6IjUiLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoibG9nbyIsInRpdGxlIjoiTG9nbyIsIndlaWdodCI6MH0seyJjb2xsZyI6IjkiLCJjb2xtZCI6IjkiLCJjb2xzbSI6IjkiLCJjb2x4cyI6IjciLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoibmF2aWdhdGlvbiIsInRpdGxlIjoiTmF2aWdhdGlvbiIsIndlaWdodCI6MX1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJ5ZXMiLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJzbGlkZXIiLCJzdGlja3kiOmZhbHNlLCJ0aXRsZSI6IlNsaWRlciIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6MiwicmVnaW9ucyI6W3siY29sbGciOiIxMiIsImNvbG1kIjoiMTIiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjowLCJjb2xtZG9mZnNldCI6MCwiY29sc21vZmZzZXQiOjAsImNvbHhzb2Zmc2V0IjowLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJzbGlkZXIiLCJ0aXRsZSI6IlNsaWRlciIsIndlaWdodCI6MH1dfSx7ImJhY2tncm91bmRjb2xvciI6IiNmNWY1ZjUiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoicGFnZS13aGl0ZSBiZ3BhdHR0ZXJuIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJwYWdlLXRpdGxlIiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJQYWdlIFRpdGxlIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjozLCJyZWdpb25zIjpbeyJjb2xsZyI6IjEyIiwiY29sbWQiOiIxMiIsImNvbHNtIjoiMTIiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiYmFubmVyIiwidGl0bGUiOiJCYW5uZXIiLCJ3ZWlnaHQiOjB9LHsiY29sbGciOiIxMiIsImNvbG1kIjoiMTIiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjoiMCIsImNvbG1kb2Zmc2V0IjoiMCIsImNvbHNtb2Zmc2V0IjoiMCIsImNvbHhzb2Zmc2V0IjoiMCIsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6InBhZ2V0aXRsZSIsInRpdGxlIjoiUGFnZSBUaXRsZSIsIndlaWdodCI6MX0seyJjb2xsZyI6IjEyIiwiY29sbWQiOiIxMiIsImNvbHNtIjoiMTIiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiYnJlYWRjcnVtYiIsInRpdGxlIjoiQnJlYWRjcnVtYiIsIndlaWdodCI6Mn1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJubyIsImhkZXNrdG9wIjpmYWxzZSwiaHBob25lIjpmYWxzZSwiaHRhYmxldCI6ZmFsc2UsImtleSI6ImZlYXR1cmVzIiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJGZWF0dXJlcyIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6NCwicmVnaW9ucyI6W3siY29sbGciOiIxMiIsImNvbG1kIjoiMTIiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjoiMCIsImNvbG1kb2Zmc2V0IjoiMCIsImNvbHNtb2Zmc2V0IjoiMCIsImNvbHhzb2Zmc2V0IjoiMCIsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6ImZlYXR1cmUiLCJ0aXRsZSI6IkZlYXR1cmUiLCJ3ZWlnaHQiOjB9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiYmctZ3JheSIsImZ1bGx3aWR0aCI6InllcyIsImhkZXNrdG9wIjpmYWxzZSwiaHBob25lIjpmYWxzZSwiaHRhYmxldCI6ZmFsc2UsImtleSI6InVzZXItMDEiLCJzdGlja3kiOmZhbHNlLCJ0aXRsZSI6IkZlYXR1cmVzIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0Ijo1LCJyZWdpb25zIjpbeyJjb2xsZyI6IjYiLCJjb2xtZCI6IjYiLCJjb2xzbSI6IjYiLCJjb2x4cyI6IjEwIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIxIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidXNlcl8wMSIsInRpdGxlIjoiVXNlciAwMSIsIndlaWdodCI6MH0seyJjb2xsZyI6IjUiLCJjb2xtZCI6IjUiLCJjb2xzbSI6IjUiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidXNlcl8wMiIsInRpdGxlIjoiVXNlciAwMiIsIndlaWdodCI6MX1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJ5ZXMiLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJ0b3AtY29udGVudCIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiQ29udGVudCBUb3AiLCJ2ZGVza3RvcCI6ZmFsc2UsInZwaG9uZSI6ZmFsc2UsInZ0YWJsZXQiOmZhbHNlLCJ3ZWlnaHQiOjYsInJlZ2lvbnMiOlt7ImNvbGxnIjoiMTIiLCJjb2xtZCI6IjEyIiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidG9wX2NvbnRlbnQiLCJ0aXRsZSI6IlRvcCBDb250ZW50Iiwid2VpZ2h0IjowfV19LHsiYmFja2dyb3VuZGNvbG9yIjoiIiwiY29scGFkZGluZyI6IiIsImN1c3RvbV9jbGFzcyI6IiIsImZ1bGx3aWR0aCI6Im5vIiwiaGRlc2t0b3AiOmZhbHNlLCJocGhvbmUiOmZhbHNlLCJodGFibGV0IjpmYWxzZSwia2V5IjoiY29udGVudCIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiQ29udGVudCIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6NywicmVnaW9ucyI6W3siY29sbGciOiI0IiwiY29sbWQiOiI0IiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjAiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJsZWZ0X3NpZGViYXIiLCJ0aXRsZSI6IkxlZnQgc2lkZWJhciIsIndlaWdodCI6MH0seyJjb2xsZyI6IjQiLCJjb2xtZCI6IjQiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjowLCJjb2xtZG9mZnNldCI6MCwiY29sc21vZmZzZXQiOjAsImNvbHhzb2Zmc2V0IjowLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJjb250ZW50IiwidGl0bGUiOiJDb250ZW50Iiwid2VpZ2h0IjoxfSx7ImNvbGxnIjoiNCIsImNvbG1kIjoiNCIsImNvbHNtIjoiMTIiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoicmlnaHRfc2lkZWJhciIsInRpdGxlIjoiUmlnaHQgc2lkZWJhciIsIndlaWdodCI6Mn1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJ5ZXMiLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJib3R0b20tY29udGVudCIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiQ29udGVudCBCb3R0b20gRmlyc3QiLCJ2ZGVza3RvcCI6ZmFsc2UsInZwaG9uZSI6ZmFsc2UsInZ0YWJsZXQiOmZhbHNlLCJ3ZWlnaHQiOjgsInJlZ2lvbnMiOlt7ImNvbGxnIjoiMTIiLCJjb2xtZCI6IjEyIiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjAiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJjb250ZW50X2JvdHRvbV9maXJzdCIsInRpdGxlIjoiQ29udGVudCBCb3R0b20gRmlyc3QiLCJ3ZWlnaHQiOjB9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoieWVzIiwiaGRlc2t0b3AiOmZhbHNlLCJocGhvbmUiOmZhbHNlLCJodGFibGV0IjpmYWxzZSwia2V5IjoidXNlci0wMiIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiVGVhbSIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6OSwicmVnaW9ucyI6W3siY29sbGciOiI0IiwiY29sbWQiOiI0IiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjIiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJ1c2VyXzAzIiwidGl0bGUiOiJVc2VyIDAzIiwid2VpZ2h0IjowfSx7ImNvbGxnIjoiNiIsImNvbG1kIjoiNiIsImNvbHNtIjoiMTIiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidXNlcl8wNCIsInRpdGxlIjoiVXNlciAwNCIsIndlaWdodCI6MX1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiJiZy1ncmF5IiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJjb250ZW50LWJvdHRvbS1zZWNvbmQiLCJzdGlja3kiOmZhbHNlLCJ0aXRsZSI6IkNvbnRlbnQgQm90dG9tIFNlY29uZCIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6MTAsInJlZ2lvbnMiOlt7ImNvbGxnIjoiMTIiLCJjb2xtZCI6IjEyIiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjAiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJjb250ZW50X2JvdHRvbV9zZWNvbmQiLCJ0aXRsZSI6IkNvbnRlbnQgQm90dG9tIFNlY29uZCAoQm94ZWQgR3JheSBCYWNrZ3JvdW5kKSIsIndlaWdodCI6MH1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJ5ZXMiLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJ1c2VyLTAzIiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJQYXJhbGxheCIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6MTEsInJlZ2lvbnMiOlt7ImNvbGxnIjoiMTIiLCJjb2xtZCI6IjEyIiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoidXNlcl8wNSIsInRpdGxlIjoiVXNlciAwNSIsIndlaWdodCI6MH1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiJiZy1ncmF5IiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJwYXJ0bmVycyIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiUGFydG5lcnMiLCJ2ZGVza3RvcCI6ZmFsc2UsInZwaG9uZSI6ZmFsc2UsInZ0YWJsZXQiOmZhbHNlLCJ3ZWlnaHQiOjEyLCJyZWdpb25zIjpbeyJjb2xsZyI6IjEyIiwiY29sbWQiOiIxMiIsImNvbHNtIjoiMTIiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOjAsImNvbG1kb2Zmc2V0IjowLCJjb2xzbW9mZnNldCI6MCwiY29seHNvZmZzZXQiOjAsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6ImNsaWVudCIsInRpdGxlIjoiQ2xpZW50cyIsIndlaWdodCI6MH1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJ5ZXMiLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJib3R0b20tdG9wIiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJCb3R0b20gVG9wIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjoxMywicmVnaW9ucyI6W3siY29sbGciOiIxMiIsImNvbG1kIjoiMTIiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjoiMCIsImNvbG1kb2Zmc2V0IjoiMCIsImNvbHNtb2Zmc2V0IjoiMCIsImNvbHhzb2Zmc2V0IjoiMCIsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6ImJvdHRvbV90b3AiLCJ0aXRsZSI6IkJvdHRvbSBUb3AiLCJ3ZWlnaHQiOjB9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJib3R0b20iLCJzdGlja3kiOmZhbHNlLCJ0aXRsZSI6IkJvdHRvbSIsInZkZXNrdG9wIjpmYWxzZSwidnBob25lIjpmYWxzZSwidnRhYmxldCI6ZmFsc2UsIndlaWdodCI6MTQsInJlZ2lvbnMiOlt7ImNvbGxnIjoiNCIsImNvbG1kIjoiNCIsImNvbHNtIjoiNCIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjAiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJib3R0b21fZmlyc3QiLCJ0aXRsZSI6IkJvdHRvbSBGaXJzdCIsIndlaWdodCI6MH0seyJjb2xsZyI6IjQiLCJjb2xtZCI6IjQiLCJjb2xzbSI6IjQiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiYm90dG9tX3NlY29uZCIsInRpdGxlIjoiQm90dG9tIFNlY29uZCIsIndlaWdodCI6MX0seyJjb2xsZyI6IjQiLCJjb2xtZCI6IjQiLCJjb2xzbSI6IjQiLCJjb2x4cyI6IjEyIiwiY29sbGdvZmZzZXQiOiIwIiwiY29sbWRvZmZzZXQiOiIwIiwiY29sc21vZmZzZXQiOiIwIiwiY29seHNvZmZzZXQiOiIwIiwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiYm90dG9tX3RoaXJkIiwidGl0bGUiOiJCb3R0b20gVGhpcmQiLCJ3ZWlnaHQiOjJ9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJib3R0b20tYWx0Iiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJCb3R0b20gQWx0IiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjoxNSwicmVnaW9ucyI6W3siY29sbGciOiIxMiIsImNvbG1kIjoiMTIiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjowLCJjb2xtZG9mZnNldCI6MCwiY29sc21vZmZzZXQiOjAsImNvbHhzb2Zmc2V0IjowLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJib3R0b20iLCJ0aXRsZSI6IkJvdHRvbSIsIndlaWdodCI6MH1dfSx7ImJhY2tncm91bmRjb2xvciI6IiIsImNvbHBhZGRpbmciOiIiLCJjdXN0b21fY2xhc3MiOiIiLCJmdWxsd2lkdGgiOiJubyIsImhkZXNrdG9wIjpmYWxzZSwiaHBob25lIjpmYWxzZSwiaHRhYmxldCI6ZmFsc2UsImtleSI6ImZvb3RlciIsInN0aWNreSI6ZmFsc2UsInRpdGxlIjoiRm9vdGVyIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjoxNiwicmVnaW9ucyI6W3siY29sbGciOiI2IiwiY29sbWQiOiI2IiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6IjAiLCJjb2xtZG9mZnNldCI6IjAiLCJjb2xzbW9mZnNldCI6IjAiLCJjb2x4c29mZnNldCI6IjAiLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJjb3B5cmlnaHQiLCJ0aXRsZSI6IkNvcHlyaWdodCIsIndlaWdodCI6MH0seyJjb2xsZyI6IjYiLCJjb2xtZCI6IjYiLCJjb2xzbSI6IjEyIiwiY29seHMiOiIxMiIsImNvbGxnb2Zmc2V0IjoiMCIsImNvbG1kb2Zmc2V0IjoiMCIsImNvbHNtb2Zmc2V0IjoiMCIsImNvbHhzb2Zmc2V0IjoiMCIsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6ImJvdHRvbV9zb2NpYWwiLCJ0aXRsZSI6IkJvdHRvbSBTb2NpYWwiLCJ3ZWlnaHQiOjF9XX0seyJiYWNrZ3JvdW5kY29sb3IiOiIiLCJjb2xwYWRkaW5nIjoiIiwiY3VzdG9tX2NsYXNzIjoiIiwiZnVsbHdpZHRoIjoibm8iLCJoZGVza3RvcCI6ZmFsc2UsImhwaG9uZSI6ZmFsc2UsImh0YWJsZXQiOmZhbHNlLCJrZXkiOiJ1bmFzc2lnbmVkIiwic3RpY2t5IjpmYWxzZSwidGl0bGUiOiJVbmFzc2lnbmVkIiwidmRlc2t0b3AiOmZhbHNlLCJ2cGhvbmUiOmZhbHNlLCJ2dGFibGV0IjpmYWxzZSwid2VpZ2h0IjoxNywicmVnaW9ucyI6W3siY29sbGciOiIzIiwiY29sbWQiOiIzIiwiY29sc20iOiIxMiIsImNvbHhzIjoiMTIiLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiYm90dG9tX2ZvdXJ0aCIsInRpdGxlIjoiQm90dG9tIEZvdXJ0aCIsIndlaWdodCI6MH0seyJjb2xsZyI6NiwiY29sbWQiOjYsImNvbHNtIjoxMiwiY29seHMiOjEyLCJjb2xsZ29mZnNldCI6MCwiY29sbWRvZmZzZXQiOjAsImNvbHNtb2Zmc2V0IjowLCJjb2x4c29mZnNldCI6MCwiY3VzdG9tX2NsYXNzIjoiIiwia2V5IjoiZGFzaGJvYXJkX21haW4iLCJ0aXRsZSI6IkRhc2hib2FyZCAobWFpbikiLCJ3ZWlnaHQiOjF9LHsiY29sbGciOjYsImNvbG1kIjo2LCJjb2xzbSI6MTIsImNvbHhzIjoxMiwiY29sbGdvZmZzZXQiOjAsImNvbG1kb2Zmc2V0IjowLCJjb2xzbW9mZnNldCI6MCwiY29seHNvZmZzZXQiOjAsImN1c3RvbV9jbGFzcyI6IiIsImtleSI6ImRhc2hib2FyZF9zaWRlYmFyIiwidGl0bGUiOiJEYXNoYm9hcmQgKHNpZGViYXIpIiwid2VpZ2h0IjoyfSx7ImNvbGxnIjo2LCJjb2xtZCI6NiwiY29sc20iOjEyLCJjb2x4cyI6MTIsImNvbGxnb2Zmc2V0IjowLCJjb2xtZG9mZnNldCI6MCwiY29sc21vZmZzZXQiOjAsImNvbHhzb2Zmc2V0IjowLCJjdXN0b21fY2xhc3MiOiIiLCJrZXkiOiJkYXNoYm9hcmRfaW5hY3RpdmUiLCJ0aXRsZSI6IkRhc2hib2FyZCAoaW5hY3RpdmUpIiwid2VpZ2h0IjozfV19XSwicGFnZXMiOiIiLCJpc2RlZmF1bHQiOnRydWV9XQ==';
  var $presets;
  var $preset = 0;
  var $lessc;
  var $lessc_vars = array();

  function __construct($key){
    $this->theme = $key;
    $this->layouts();
    $p = theme_get_setting('innovation_presets', $this->theme);
    $init_presets = 1;

    if (empty($p)) {
      $func = $this->theme . '_default_presets';
      if (function_exists($func)) {
        $p = call_user_func($func);
      } else{
        //Load layout form base theme
        $themes = system_list('theme');
        if(isset($themes[$this->theme]->info['base theme'])){
          $base_theme = $themes[$this->theme]->info['base theme'];
          if(file_exists(DRUPAL_ROOT.'/'.drupal_get_path('theme',$base_theme).'/innovation.theme')){
            require_once DRUPAL_ROOT.'/'.drupal_get_path('theme',$base_theme).'/innovation.theme';
            $func = $base_theme . '_default_presets';
            if (function_exists($func)) {
              $p = call_user_func($func);
            }
          }
        }
      }
    }

    $this->presets = json_decode(base64_decode($p));
    $infunc = $this->theme . '_init_presets';
    if(function_exists($infunc)){
      $init_presets = call_user_func($infunc);
    }
    $this->presets = array_slice($this->presets, 0, $init_presets);
    for($i=0; $i<$init_presets; $i++){
      if(!isset($this->presets[$i])){
        $newpreset = new stdClass();
        $newpreset->key = 'Preset '.($i+1);
        $newpreset->base_color = '#666666';
        $newpreset->base_color_opposite = '#666666';
        $newpreset->link_color = '#666666';
        $newpreset->link_hover_color = '#666666';
        $newpreset->text_color = '#666666';
        $newpreset->heading_color = '#666666';
        $this->presets[] = $newpreset;
      }
    }
	$this->style = theme_get_setting('innovation_layout');
    if(\Drupal::moduleHandler()->moduleExists('inv_quicksettings')){
	//print $_SESSION['innovation_default_preset'];
      $this->preset = isset($_SESSION['innovation_default_preset']) ? $_SESSION['innovation_default_preset'] : theme_get_setting('innovation_default_preset');
	  //$this->style = isset($_SESSION['innovation_layout']) ? $_SESSION['innovation_layout'] : theme_get_setting('innovation_layout');
    } else {
      $this->preset = theme_get_setting('innovation_default_preset');
    }
	//print $this->preset;
    if($this->preset == '' || $this->preset == null){
      $this->preset = 0;
    }
    $this->setPresetVars();
    $this->lessc = $this->getLessFiles();
  }

  public function getLessFiles() {
    $path = drupal_get_path('theme',$this->theme);
    $files = glob($path."/lessc/*.less");
    return $files;
  }

  public function setPresetVars($preset = null) {
	$pagewidth = theme_get_setting('drupalexp_pagewidth');
    if(empty($pagewidth)) $pagewidth = 1170;
    $this->lessc_vars['container_width'] = $pagewidth.'px';
    if ($preset == null) {
      $preset = empty($this->preset)?0:$this->preset;
    }
    $default_preset = $this->presets[$preset];
    if ($default_preset) {
      $this->lessc_vars['base_color'] = $default_preset->base_color;
      $this->lessc_vars['base_color_opposite'] = isset($default_preset->base_color_opposite)      ?$default_preset->base_color_opposite:$default_preset->base_color;
      $this->lessc_vars['link_color'] = $default_preset->link_color;
      $this->lessc_vars['link_hover_color'] = $default_preset->link_hover_color;
      $this->lessc_vars['text_color'] = $default_preset->text_color;
      $this->lessc_vars['heading_color'] = $default_preset->heading_color;
    }
  }

  function getRegions(){
    return system_region_list($this->theme);
  }
  
  private function layouts() {
    $theme_regions = system_region_list($this->theme);
    $l = theme_get_setting('innovation_layouts', $this->theme);
    if (!empty($l)) {
      $this->layouts = json_decode(base64_decode($l));
      $this->__addRegions();
      $this->__removeRegions();
    } else {
      $func = $this->theme . '_default_layouts';
      if (function_exists($func)) {
        $default_layout = $func();
        $this->layouts = json_decode(base64_decode($default_layout));
        $this->__addRegions();
        $this->__removeRegions();
        return;
      }else{
        //Load layout from base theme
        $themes = system_list('theme');
        if(isset($themes[$this->theme]->info['base theme'])){
          $base_theme = $themes[$this->theme]->info['base theme'];
          if(file_exists(DRUPAL_ROOT.'/'.drupal_get_path('theme',$base_theme).'/innovation.theme')){
            require_once DRUPAL_ROOT.'/'.drupal_get_path('theme',$base_theme).'/innovation.theme';
            $func = $base_theme . '_default_layouts';
            if (function_exists($func)) {
              $default_layouts = call_user_func($func);
              $this->layouts = json_decode(base64_decode($default_layouts));
              $this->__addRegions();
              $this->__removeRegions();
              return;
            }
          }
        }else{
          $this->layouts = json_decode(base64_decode($this->defaultLayoutStr));
          $this->__addRegions();
          $this->__removeRegions();
        }
      }
      $theme_regions = system_region_list($this->theme);
      $regions = array();
      $weight = 0;
      foreach ($theme_regions as $key => $title) {
        $region = new stdClass();
        $region->key = $key;
        $region->title = $title;
        $region->size = 6;
        $regions[] = $region;
      }
      $unassignedsection = new stdClass();
      $unassignedsection->key = 'unassigned';
      $unassignedsection->title = 'Unassigned';
      $unassignedsection->regions = $regions;
      $layout = new stdClass();
      $layout->key = 'default';
      $layout->title = 'Default';
      $layout->sections = array($unassignedsection);
      $this->layouts = array($layout);
    }
  }

  private function __addRegions(){
    $theme_regions = system_region_list($this->theme);
    foreach ($theme_regions as $key => $title) {
      foreach ($this->layouts as $k => $layout) {
        $region_exists = false;
        $unassigned_section = 0;
        foreach ($layout->sections as $section_index => $section) {
          if ($section->key == 'unassigned') {
            $unassigned_section = $section_index;
          }
          foreach ($section->regions as $region_index => $region) {
            if (!isset($region->key)) {
              unset($section->regions[$region_index]);
              continue;
            }
            if ($region->key == $key) {
              //Update title
              $this->layouts[$k]->sections[$section_index]->regions[$region_index]->title = $title;
              $region_exists = true;
            }
          }
          $section->regions = array_values($section->regions);
        }
        if (!$region_exists) {
          $newregion = new stdClass();
          $newregion->key = $key;
          $newregion->title = $title;
          $newregion->size = 6;
          $this->layouts[$k]->sections[$unassigned_section]->regions[] = $newregion;
        }
      }
    }
  }
  
  private function __removeRegions() {
    $theme_regions = system_region_list($this->theme);
    $theme_regions_keys = array();
    foreach ($theme_regions as $key => $region) {
      $theme_regions_keys[] = $key;
    }
    foreach ($this->layouts as $k => $layout) {
      $region_exists = false;
      foreach ($layout->sections as $section_index => $section) {
        foreach ($section->regions as $region_index => $region) {
          if (!in_array($region->key, $theme_regions_keys)) {
            unset($this->layouts[$k]->sections[$section_index]->regions[$region_index]);
          }
        }
        $this->layouts[$k]->sections[$section_index]->regions = array_values($this->layouts[$k]->sections[$section_index]->regions);
      }
    }
  }
  
  function pageRender() {
    $this->layout = $this->get_layout();
    if (!isset($this->layouts[$this->layout])) {
      $this->layout = 0;
    }
    $html = "";
    foreach ($this->layouts[$this->layout]->sections as $section) {
      $html .= $this->sectionRender($section);
    }
    return '<div class="inv-body-inner ' . $this->layouts[$this->layout]->key . '">' . $html . '</div>';
  }
  
  function sectionRender($section) {
    if (empty($section->regions) || $section->key == 'unassigned') {
      return '';
    }
    $content = '';
    foreach ($section->regions as $region) {
      if ($region_content = $this->regionRender($region)) {
        $content .= $region_content;
      }
    }
    if ($content) {
      $render_array = [
        '#theme' => 'inv-section',
        '#content' => ['#markup' => Markup::create($content)],
        '#section' => $section,
        '#attributes' => [
          'id' => Html::getId('section-'.$section->key),
          'class' => [Html::getClass('inv-section')],
        ],
      ];
      return drupal_render($render_array);
    }
    return "";
  }
  
  function regionRender($region) {
    $drupal_static = &drupal_static(__FUNCTION__);
    if (!isset($drupal_static[$region->key])) {
       $content = drupal_render($this->page['page'][$region->key]);
       if($content){
            $region_class = Html::getClass('region-'.$region->key);
            $drupal_static[$region->key] =  '<!-- .'.$region_class.'-->'.PHP_EOL.$content.'<!-- END .'.$region_class.'-->'.PHP_EOL;
        }else{
            $drupal_static[$region->key] = '';
       }
    }
    return $drupal_static[$region->key];
  }
  
  function getRegion($region_key) {
    $ret = null;
    if (!isset($this->layouts[$this->layout])) {
      $this->layout = 0;
    }
    foreach ($this->layouts[$this->layout]->sections as $section_index => $section) {
      foreach ($section->regions as $region_index => $region) {
        if ($region->key == $region_key) {
          $ret = $region;
          if ($region_key == 'content') {
            innovation_calculate_primary($section_index, $region_index);
          }
        }
      }
    }
    return $ret;
  }
  
  function get_layout() {
   $alias = \Drupal::service('path.current')->getPath();
		$return = 0;
    foreach ($this->layouts as $k => $layout) {
			if (isset($layout->isdefault) && $layout->isdefault){
        $return = $k;
        continue;
      }
      $pages = isset($layout->pages)?$layout->pages:'';
			if (empty($pages))
        continue;
			if (\Drupal::service('path.matcher')->matchPath($alias, $pages)) {
      	return $k;
      }
    }
    return $return;
  }
}

function innovation_get_theme(){
  $drupal_static = &drupal_static(__FUNCTION__);
  $key = \Drupal::theme()->getActiveTheme()->getName();
  if (!isset($drupal_static[$key])) {
    $drupal_static[$key] = new InnovationTheme($key);
  }
  return $drupal_static[$key];
}

/**
 * Calculate primary column width
 */
function innovation_calculate_primary($section_index, $primary_region_index) {
  $theme = innovation_get_theme();
  $devices = array('colxs', 'colsm', 'colmd', 'collg');
  foreach ($devices as $device) {
    $theme->layouts[$theme->layout]->sections[$section_index]->regions[$primary_region_index]->$device = 12;
    foreach ($theme->layouts[$theme->layout]->sections[$section_index]->regions as $region_index => $region) {
      if ($region_index != $primary_region_index) {
        if (Element::children($theme->page['page'][$region->key])) {
          $theme->layouts[$theme->layout]->sections[$section_index]->regions[$primary_region_index]->$device -= $theme->layouts[$theme->layout]->sections[$section_index]->regions[$region_index]->$device;
          if ($theme->layouts[$theme->layout]->sections[$section_index]->regions[$primary_region_index]->$device <= 0) {
            $theme->layouts[$theme->layout]->sections[$section_index]->regions[$primary_region_index]->$device = 12;
          }
        }
      }
    }
  }
}
