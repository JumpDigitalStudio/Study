#include "pch.h"
#include <Windows.h>
#include <stdio.h>

int  numbers[4] = { 1,2,3,4 };
CRITICAL_SECTION CriricalSection;

DWORD WINAPI THR1(LPVOID lpParametr)
{
    HANDLE HEVENT = *((HANDLE*)lpParametr);
    WaitForSingleObject(HEVENT, INFINITE);
    EnterCriticalSection(&CriricalSection);
    printf("Выполняется первый поток\n");
    printf("Войти с первого\n");
    for (int i = 0; i < 4; i++)
    {
        printf("%d ", numbers[i]);
        Sleep(20);
    }
    printf("\n)");
    LeaveCriticalSection(&CriricalSection);
    return 1;
}
DWORD WINAPI THR2(LPVOID lpParametr)
{
    HANDLE HEVENT = *((HANDLE*)lpParametr);
    WaitForSingleObject(HEVENT, INFINITE);
    EnterCriticalSection(&CriricalSection);
    printf("Выполняется второй поток\n");
    printf("Войти со второго\n");
    for (int i = 0; i < 4; i++)
    {
        printf("%d ", numbers[i]);
        Sleep(20);
    }
    printf("\n)");
    LeaveCriticalSection(&CriricalSection);
    return 1;
}

int main(int args,char** argv)
{
    HANDLE HEVENT = CreateEvent(NULL, TRUE, FALSE, NULL);
    HANDLE KTHREADS[2];
    KTHREADS[0] = CreateThread(NULL, 0, THR1, (VOID*)&HEVENT, 0, NULL);
    KTHREADS[1]= CreateThread(NULL, 0, THR2, (VOID*)&HEVENT, 0, NULL);
    WaitForMultipleObjects(2, KTHREADS, TRUE, INFINITE);
    DeleteCriticalSection(&CriricalSection);
    CloseHandle(KTHREADS[0]);
    CloseHandle(KTHREADS[1]);
    CloseHandle(HEVENT);
    printf("Конец\n");
    return 0;
}
