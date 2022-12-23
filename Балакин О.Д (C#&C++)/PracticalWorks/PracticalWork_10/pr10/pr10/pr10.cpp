// pr10.cpp : Этот файл содержит функцию "main". Здесь начинается и заканчивается выполнение программы.
//

#include <iostream>
#include <Windows.h>
#include <stdio.h>
#include <string>
using namespace std;
PVOID a;
int main()
{
	setlocale(LC_ALL, "Russian");
	SYSTEM_INFO inf;
	GetSystemInfo(&inf);

	a = VirtualAlloc(NULL, inf.dwPageSize, MEM_RESERVE | MEM_TOP_DOWN, PAGE_READWRITE);
	VirtualAlloc(a, inf.dwPageSize, MEM_COMMIT, PAGE_READWRITE);

	std::cout << std::hex << (int(a)) << "h" << endl;
	FillMemory(a, inf.dwPageSize, 127);
	__int8* p = static_cast<__int8*>(a);
	std::cout << std::hex << (__int8(*(p))) << "h" << endl;

	PMEMORY_BASIC_INFORMATION pmbi = new MEMORY_BASIC_INFORMATION;
	VirtualQuery(a, pmbi, sizeof(*pmbi));

	std::cout << "Суммарный размер страниц: " << std::to_string(__int64(pmbi->RegionSize)) << endl;
	std::cout << "Атрибут защииты региона: ";

	switch (pmbi->AllocationProtect)
	{
	case PAGE_READWRITE:
		cout << "PAGE_READWRITE"<< endl;
		break;
	default:
		cout<< "UNKNOWN";
		break;
	}
	cout << "Базовый адрес региона: " << std::hex << int(pmbi->BaseAddress) << "h" << endl;
	cout << "Тип региона: ";
	switch (pmbi->State)
	{
	case MEM_FREE:
		cout << "FREE" << endl;
		break;
	case MEM_RESERVE:
		cout << "RESERVE" << endl;
		break;
	case MEM_COMMIT:
		cout << "COMMIT" << endl;
		break;
	default:
		cout << "Unknown" << endl;
		break;
	}
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
