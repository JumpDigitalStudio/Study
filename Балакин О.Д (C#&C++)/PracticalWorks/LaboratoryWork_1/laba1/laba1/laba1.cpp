// laba1.cpp : Этот файл содержит функцию "main". Здесь начинается и заканчивается выполнение программы.
//

#include <iostream>
#include <ctime>
#include <Windows.h>
#include <Netsh.h> 
#pragma warning(disable:4996)
#define INFO_BUFFER_SIZE 32767
#define _CRT_SECURE_NO_WARNINGS

using namespace std;

int main()
{
    TCHAR  infoBuf[INFO_BUFFER_SIZE];
    DWORD  bufCharCount = INFO_BUFFER_SIZE;
    // Получить и отобразить имя компьютера
    if (GetComputerName(infoBuf, &bufCharCount))
        wcout << "PcName: " << infoBuf << endl;

    TCHAR sysDir[MAX_PATH];
    GetSystemDirectory(sysDir, MAX_PATH);
    wcout << "SysDir: " << sysDir << endl;

    const DWORD encodedVersion = ::GetVersion();
    const unsigned majorVersion = unsigned(LOBYTE(LOWORD(encodedVersion)));
    const unsigned minorVersion = unsigned(HIBYTE(LOWORD(encodedVersion)));

    std::printf("Windows ver: %u.%u\n", majorVersion, minorVersion);

	time_t sec;
	int kolichestvo_dney;

	sec = time(NULL);
	kolichestvo_dney = (sec / 3600) / 24;
	cout << kolichestvo_dney << " " << asctime(localtime(&sec));
	cin.get();
	return 0;
}

// Запуск программы: CTRL+F5 или меню "Отладка" > "Запуск без отладки"
// Отладка программы: F5 или меню "Отладка" > "Запустить отладку"

// Советы по началу работы 
//   1. В окне обозревателя решений можно добавлять файлы и управлять ими.
//   2. В окне Team Explorer можно подключиться к системе управления версиями.
//   3. В окне "Выходные данные" можно просматривать выходные данные сборки и другие сообщения.
//   4. В окне "Список ошибок" можно просматривать ошибки.
//   5. Последовательно выберите пункты меню "Проект" > "Добавить новый элемент", чтобы создать файлы кода, или "Проект" > "Добавить существующий элемент", чтобы добавить в проект существующие файлы кода.
//   6. Чтобы снова открыть этот проект позже, выберите пункты меню "Файл" > "Открыть" > "Проект" и выберите SLN-файл.
