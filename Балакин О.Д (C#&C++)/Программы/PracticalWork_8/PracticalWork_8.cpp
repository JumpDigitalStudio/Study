// PracticalWork_8.cpp : Этот файл содержит функцию "main". Здесь начинается и заканчивается выполнение программы.
//

#include <Windows.h>
#include <iostream>
#include <thread>
#include <mutex>

std::mutex g_lock;

void threadFunc()
{
	g_lock.lock();
	while (true)
	{
		std::cout << "ancara messi" << std::endl;
	}
}

int main()
{
	
}
