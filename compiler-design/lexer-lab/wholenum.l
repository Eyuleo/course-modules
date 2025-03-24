%{
#include <stdio.h>
%}
%%
[0-9]+              { printf("whole number\n"); }
[+-]?[0-9]+\.[0-9]+ { printf("decimal number\n"); }
%%
int yywrap(void) {
}
int main(){yylex();}

