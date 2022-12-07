#include "pch.h"
#include "framework.h"
#include "Library.h"

namespace Library
{
	double Arithmetic::Add(double a, double b)
	{
		return a + b;
	}
	double Arithmetic::Substract(double a, double b)
	{
		return a - b;
	}
	double Arithmetic::Multiply(double a, double b)
	{
		return a * b;
	}
	double Arithmetic::Divide(double a, double b)
	{
		return a / b;
	}
}