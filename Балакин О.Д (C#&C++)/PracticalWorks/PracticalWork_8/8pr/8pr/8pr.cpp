#include <iostream>
#include <thread>
#include <mutex>
#include <Windows.h>

std::mutex g_lock;

void threadFunction()
{
    g_lock.lock();
    while (true)
    {
        std::cout << "1111" << std::endl;
    }
    g_lock.unlock();
}

int main()
{
    HANDLE hHeap = HeapCreate(HEAP_NO_SERIALIZE, 1024 * 1024, 2048 * 1024);
    std::thread t1(threadFunction);
    std::thread t2(threadFunction);
    std::thread t3(threadFunction);

    t1.join();
    t2.join();
    t3.join();
}
