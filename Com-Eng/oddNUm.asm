.model small
.stack 100h

.data
    result db 0            ; variable to store the result
    output_buffer db 16 dup(0) ; buffer to store the ASCII representation of the result

.code
    mov ax, @data
    mov ds, ax

    mov cx, 10      ; Set the loop counter to 10 (we will iterate from 1 to 10)
    mov bx, 1       ; Start with the number 1
    mov byte ptr result, 0 ; Initialize the result to 0

add_loop:
    cmp bx, 11      ; Check if bx is greater than 10 (the loop end condition)
    jg print_result ; If bx is greater than 10, jump to print_result

    test bl, 1      ; Test the least significant bit (LSB) of bx (odd numbers have LSB set to 1)
    jnz add_number  ; If it's an odd number, jump to add_number label

increment:
    inc bx         ; Increment bx
    jmp add_loop   ; Jump back to the beginning of the loop

add_number:
    add byte ptr result, bl ; Add the current odd number (bx) to the result
    jmp increment  ; Jump to the increment label to move to the next number

print_result:
    ; At this point, the sum of odd numbers between 1 and 10 will be stored in [result].

    ; Convert the result to an ASCII string (null-terminated) and store it in output_buffer.
    mov ax, word ptr [result]
    mov di, offset output_buffer
    call int_to_ascii

    ; Print the result to the console
    mov si, offset output_buffer ; Pointer to the buffer
    call print_string

    ; Exit the program
    mov ah, 4Ch     ; DOS function to terminate the program with return code 0
    int 21h         ; Call DOS interrupt

; Function to convert an integer to an ASCII string
; Input:  ax - the integer to convert
;         di - pointer to the buffer to store the resulting ASCII string
; Modifies: ax, bx, cx, dx
int_to_ascii PROC
    mov bx, 10      ; Base 10
    xor dx, dx      ; Clear dx to prepare for division
int_to_ascii_loop:
    xor cx, cx      ; Clear cx for division
    div bx          ; Divide ax by 10, result in ax, remainder in dx
    add dl, '0'     ; Convert the remainder to ASCII
    dec di          ; Move the pointer backward in the buffer
    mov byte ptr [di], dl ; Store the ASCII character in the buffer
    test ax, ax     ; Check if ax is zero (division result)
    jnz int_to_ascii_loop ; If not zero, continue the loop
    mov byte ptr [di-1], '$' ; Null-terminate the string with '$'
    ret
int_to_ascii ENDP

; Function to print a null-terminated string to the console
; Input:  si - pointer to the null-terminated string to print
print_string PROC
    mov ah, 02h     ; DOS function to display a character
print_loop:
    lodsb           ; Load next character from DS:SI into AL and increment SI
    test al, al     ; Check if AL is zero (null terminator)
    jz print_done   ; If null terminator, we are done printing
    int 21h         ; Print the character
    jmp print_loop  ; Continue printing the next character
print_done:
    ret
print_string ENDP

END
