using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_11
{
    internal class Caretacker
    {
        public Stack<State> Stetes = new Stack<State>();

        public State pop()
        {
            return Stetes.Pop();
        }

        public void push(State s)
        {
            Stetes.Push(s);
        }
    }
}
