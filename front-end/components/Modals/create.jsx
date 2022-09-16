import {
  Button,
  FormControl,
  FormLabel,
  Input,
  ModalBody,
  ModalHeader,
  Text,
} from "@chakra-ui/react";
import { useState } from "react";
import { customAxios } from "../../service/axios";

const ModalCreate = () => {
  const [values, setValues] = useState({});
  const [errors, setErrors] = useState({});

  const onChange = (e) => {
    const value = e.target.value;
    const name = e.target.name;

    setValues({
      ...values,
      [name]: value,
    });
  };

  const onSubmit = (e) => {
    e.preventDefault();

    customAxios
      .post("/usuarios", values)
      .then(() => alert("Usuario criado com sucesso"))
      .catch((error) => {
        setErrors(error.response.data.data);
      });
  };

  return (
    <>
      <ModalHeader>Criar Usuario</ModalHeader>

      <ModalBody pb={6}>
        <form onSubmit={onSubmit}>
          <FormControl mt={4}>
            <FormLabel>Nome</FormLabel>
            <Input onChange={onChange} type={"text"} name="name" />
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Data de Nascimento</FormLabel>
            <Input onChange={onChange} type={"date"} name="birthdate" />
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Email</FormLabel>
            <Input
              onChange={onChange}
              type={"email"}
              name="email"
              isInvalid={errors?.email}
            />
            {errors?.email && (
              <Text fontSize="sm" color="red.600">
                {errors.email.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Senha</FormLabel>
            <Input
              type={"password"}
              name="password"
              placeholder="Senha"
              onChange={onChange}
            />
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Confirmar senha</FormLabel>
            <Input
              type={"password"}
              name="password_confirmation"
              placeholder="Confirmar senha"
              onChange={onChange}
            />
          </FormControl>
          <Button type="submit">Salvar</Button>
        </form>
      </ModalBody>
    </>
  );
};

export default ModalCreate;
