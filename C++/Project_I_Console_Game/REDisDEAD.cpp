#include <iostream>
#include <conio.h>
#include <windows.h>
#include <cstdlib>
#include <ctime>

using namespace std;

const int szerokosc=12, wysokosc=20;
int wybor, x, y, przeszkodaX, przeszkodaY, nagrodaX, nagrodaY, wynik;
enum eDirecton {STOP=0, LEFT, RIGHT};
eDirecton dir;
bool gameover;

void baner()
{
HANDLE hOut;
hOut=GetStdHandle( STD_OUTPUT_HANDLE );
SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_INTENSITY );

cout<<endl;
cout<<endl;
cout<<"     RRRRRRR EEEEEEE DDDDD      \n";  
cout<<"     RR   RR EE      DD  DD     \n";  
cout<<"     RRRRRRR EEEEEEE DD   DD    \n";                                        
cout<<"     RRRR    EEEEEEE DD   DD    \n";     
cout<<"     RR  RR  EE      DD  DD     \n";                            
cout<<"     RR   RR EEEEEEE DDDDD      \n";                    

hOut=GetStdHandle( STD_OUTPUT_HANDLE );
SetConsoleTextAttribute( hOut, FOREGROUND_GREEN|FOREGROUND_RED|FOREGROUND_BLUE| FOREGROUND_INTENSITY );

cout<<"                                                          \n";
cout<<"                DDDDD   EEEEEEE      A      DDDDD         \n";
cout<<"     ii SSSSS   DD  DD  EE          AAA     DD  DD        \n";
cout<<"        SS      DD   DD EEEEEEE    AAAAA    DD   DD	     \n";
cout<<"     II SSSSS   DD   DD EEEEEEE   AAAAAAA   DD   DD	     \n";
cout<<"     II    SS   DD  DD  EE       AAAAAAAAA  DD  DD        \n";
cout<<"     II SSSSS   DDDDD   EEEEEEE AAAAAAAAAAA DDDDD  	     \n";
cout<<"	                            					         \n";
}

void setup()
{
	gameover=false;
	dir=STOP;
	x=wysokosc-4;
	y=szerokosc/2;
	srand( time( NULL ) );
	przeszkodaY=(rand() % 8 ) + 0; //losuje 0, 1, 2 do 7
    przeszkodaX=1;
    nagrodaX=(rand() % 13) + 0; //szerokosc
    nagrodaY=rand() % wysokosc;
}

void clearscreen() // czyszczenie ekranu
{
    HANDLE hOut;
    COORD Position;

    hOut = GetStdHandle(STD_OUTPUT_HANDLE);

    Position.X = 0;
    Position.Y = 0;
    SetConsoleCursorPosition(hOut, Position);
}

void mapa()
{
HANDLE hOut;
hOut=GetStdHandle(STD_OUTPUT_HANDLE);

	SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_INTENSITY );	
	for (int i=0; i<szerokosc+4; i++)	//+4 bo podwojna ramka
	{
    	cout<<(char)219;
	}
		cout<<endl;
	
	for (int i=0; i<wysokosc; i++)
	{
        for (int j=0; j<szerokosc; j++)
        {
        	if (j==0)
            cout<<(char)219<<(char)219; //podwojna ramka boczna
 
			SetConsoleTextAttribute( hOut, FOREGROUND_GREEN|FOREGROUND_RED|FOREGROUND_BLUE| FOREGROUND_INTENSITY );            
            if (i==x && j==y)
            cout<<(char)30; //rakieta 193, 30, 206, 202
            SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_INTENSITY ); //kolor przeszkody
            if (i==x && j==y)
            j=y+1;
                        
          	else if (i==przeszkodaX && j==przeszkodaY)
            cout<<(char)219<<(char)219<<(char)219<<(char)219<<(char)219;
            SetConsoleTextAttribute( hOut, FOREGROUND_BLUE| FOREGROUND_GREEN | FOREGROUND_INTENSITY ); //kolor nagrody
            if (i==przeszkodaX && j==przeszkodaY)
			j=przeszkodaY+4; //ramka na wysokosci przeszkody
			
			else if (i==nagrodaX && j==nagrodaY)
			cout<<"o";
			           
          		else
            	{
					cout<<" ";
				}
			
			SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_INTENSITY );
			if (j==szerokosc-1)
			cout<<(char)219<<(char)219;
			
		}
		cout<<endl;
	}
	
	for (int i=0; i<szerokosc+4; i++)
	{
    	cout<<(char)219;
	}
    	cout<<endl<<endl;	
    	SetConsoleTextAttribute( hOut, FOREGROUND_BLUE| FOREGROUND_GREEN | FOREGROUND_INTENSITY );
    	cout<<"Wynik: "<<wynik<<endl<<endl;
}

void sterowanie()
{
    if (_kbhit())
    {
        switch (_getch())
        {
        case 'a':
        	case 'A':
            dir = LEFT;
            break;
        case 'd':
        	case 'D':
            dir = RIGHT;
            break;
        }
    }
}

void logika()
{

	switch (dir)
    {
    case LEFT:
        y=y-1;
        dir=STOP;
        break;
    case RIGHT:
        y=y+1;
        dir=STOP;
        break;
	default:
        break;
    }
    
    przeszkodaX++; //przeszkoda spadada w dol
    Sleep(70);
	
	nagrodaX++;
	Sleep(70);
	
	if (nagrodaX==wysokosc) //generowanie nowej nagrody
	{
		nagrodaX=1;
    	nagrodaY=rand() % szerokosc;
	}
	
		if (x==nagrodaX && y==nagrodaY) //nowa nagroda po zjedzeniu
	{
		wynik+=10;
        nagrodaX=rand() % 1;
        nagrodaY=rand() % szerokosc;
	}
	
	if (przeszkodaX==wysokosc) //generowanie kolejnej przeszkoda
	{
		przeszkodaX=1;
		przeszkodaY=(rand() % 8 ) + 0;
	}
	
	if (y==-1 | y==12) //jesli wjedzie na ramke to gameover
	gameover=true;
	
	if (x==przeszkodaX && y==przeszkodaY) //jesli uderzymy w przeszkode
	{
		gameover=true;
	}
	if (x==przeszkodaX && y==przeszkodaY+1)
	{
		gameover=true;
	}
	if (x==przeszkodaX && y==przeszkodaY+2)
	{
		gameover=true;
	}
	if (x==przeszkodaX && y==przeszkodaY+3)
	{
		gameover=true;
	}
	if (x==przeszkodaX && y==przeszkodaY+4)
	{
		gameover=true;
	}
	
}	



int main()
{

cout<<endl<<endl;
baner();
cout<<endl;

HANDLE hOut;
hOut=GetStdHandle( STD_OUTPUT_HANDLE );
SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_GREEN |FOREGROUND_INTENSITY );

cout<<"     [1]+[ENTER] Graj"<<endl;
cout<<"     [2]+[ENTER] Zakoncz gre"<<endl<<endl;
cout<<"---------------------------------------------------- \n";
cout<<endl;

SetConsoleTextAttribute( hOut, FOREGROUND_GREEN|FOREGROUND_RED|FOREGROUND_BLUE| FOREGROUND_INTENSITY );

cout<<"     STEROWANIE: "<<endl;
cout<<"     [A] - w lewo"<<endl;
cout<<"     [D] - w prawo"<<endl<<endl;
cout<<"     ZASADY: "<<endl;

SetConsoleTextAttribute( hOut, FOREGROUND_RED| FOREGROUND_INTENSITY );

cout<<"     "<<(char)219<<" - unikaj"<<endl;

SetConsoleTextAttribute( hOut, FOREGROUND_BLUE| FOREGROUND_GREEN | FOREGROUND_INTENSITY );

cout<<"     o - zbieraj punkty"<<endl;


cin>>wybor;
system("cls");

switch(wybor)
{
	case 1:
		setup();
		while (gameover==false)
		{
			clearscreen();
		//	system("cls");
			mapa();
			sterowanie();
			logika();
		}
		
		if(gameover==true)
		cout<<"PRZEGRALES!"<<endl;
		Sleep(5000);
		system("cls");
		wynik=0;
		main();
		
		break;
	
	case 2:
		
		return 0;
}
	
}
		








